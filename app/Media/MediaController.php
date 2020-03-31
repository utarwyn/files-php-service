<?php

namespace MediasService\Media;

use MediasService\Controller;
use MediasService\Identifier\IdentifierStrategy;
use MediasService\Identifier\IdentifierStrategyFactory;
use MediasService\Storage\Storage;
use MediasService\Storage\StorageFactory;
use MediasService\Upload\TooLargeUploadedFileException;
use MediasService\Upload\UploadedFile;
use MediasService\Upload\UploadValidator;
use MediasService\Upload\WrongTypeUploadedFileException;

/**
 * Class MediaController.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package MediasService\Media
 * @since   1.0.0
 */
class MediaController extends Controller
{
    /**
     * @var Storage storage wrapper to manage medias
     */
    private $storage;

    /**
     * @var IdentifierStrategy strategy class to manage media identifiers
     */
    private $identifierStrategy;

    /**
     * @var UploadValidator the upload validator
     */
    private $uploadValidator;

    /**
     * MediaController constructor.
     */
    public function __construct()
    {
        $this->storage = StorageFactory::create();
        $this->uploadValidator = new UploadValidator();
        $this->identifierStrategy = IdentifierStrategyFactory::create();
    }

    /**
     * Manage GET requests to retreive a media.
     * @param $identifier string identifier of media
     */
    public function get($identifier)
    {
        $this->validateIdentifier($identifier);

        try {
            $media = $this->storage->getMedia($identifier);

            header('Content-Type: ' . $media->getType());
            $this->sendCacheHeader($media);

            echo $media->getContent();
        } catch (MediaNotExistsException $e) {
            $this->notFound(
                'UNKNOWN_DOCUMENT',
                sprintf('File %s does not exist.', $e->getIdentifier())
            );
        }
    }

    /**
     * @param $identifier string identifier to validate
     */
    private function validateIdentifier($identifier)
    {
        if (!$this->identifierStrategy->validate($identifier)) {
            $this->badRequest(
                'INVALID_IDENTIFIER',
                'The provided identifier does not respect the strategy.'
            );
        }
    }

    /**
     * Send cache headers if needed when displaying a media.
     * @param $media Media media
     */
    private function sendCacheHeader($media)
    {
        $mtime = @filemtime($media->getPath());

        if ($mtime > 0) {
            $gmt_mtime = gmdate('D, d M Y H:i:s', $mtime) . ' GMT';
            $etag = sprintf('%08x-%08x', crc32($media->getPath()), $mtime);

            header('ETag: "' . $etag . '"');
            header('Last-Modified: ' . $gmt_mtime);
            header('Cache-Control: private');
        }
    }

    public function post()
    {
        $this->protectRoute();
        $this->validateFileInput();

        $file = $_FILES['file'];

        try {
            $dto = new UploadedFile(
                $file['type'],
                $file['tmp_name'],
                $file['size'],
                $file['error']
            );

            $this->uploadValidator->validate($dto);
            $identifier = $this->identifierStrategy->generate();

            $this->storage->storeMedia($identifier, $dto);
            $this->json(['identifier' => $identifier]);
        } catch (TooLargeUploadedFileException $e) {
            $this->badRequest(
                'UPLOADED_FILE_TOO_LARGE',
                sprintf('The file exceed the upload limit (%s).', $e->getReadableLimit())
            );
        } catch (WrongTypeUploadedFileException $e) {
            $this->badRequest(
                'UPLOADED_FILE_WRONG_TYPE',
                sprintf('The type %s is not allowed.', $e->getFileType())
            );
        }
    }

    public function delete($identifier)
    {
        $this->protectRoute();
        $this->validateIdentifier($identifier);

        try {
            $this->storage->deleteMedia($identifier);
            http_response_code(204);
        } catch (MediaNotExistsException $e) {
            $this->notFound(
                'UNKNOWN_DOCUMENT',
                sprintf('File %s does not exist.', $e->getIdentifier())
            );
        }
    }

    /**
     * Validate the uploaded file parameters.
     */
    private function validateFileInput()
    {
        if (!isset($_FILES['file'])) {
            $this->badRequest(
                'NO_UPLOADED_FILE',
                'The request does not contain a file.'
            );
        }

        if (
            !isset($_FILES['file']['type']) || !isset($_FILES['file']['tmp_name'])
            || !isset($_FILES['file']['size']) || !isset($_FILES['file']['error'])
        ) {
            $this->badRequest(
                'UPLOADED_FILE_INVALID',
                'The uploaded file object is invalid.'
            );
        }
    }
}
