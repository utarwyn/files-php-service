<?php

namespace FilesService\File;

use FilesService\Controller;
use FilesService\Identifier\IdentifierStrategy;
use FilesService\Identifier\IdentifierStrategyFactory;
use FilesService\Storage\Storage;
use FilesService\Storage\StorageFactory;
use FilesService\Upload\TooLargeUploadedFileException;
use FilesService\Upload\UploadedFile;
use FilesService\Upload\UploadValidator;
use FilesService\Upload\WrongTypeUploadedFileException;

/**
 * Class FileController.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package FilesService\File
 * @since   1.0.0
 */
class FileController extends Controller
{
    /**
     * @var Storage storage wrapper to manage files
     */
    private $storage;

    /**
     * @var IdentifierStrategy strategy class to manage file identifiers
     */
    private $identifierStrategy;

    /**
     * @var UploadValidator the upload validator
     */
    private $uploadValidator;

    /**
     * FileController constructor.
     */
    public function __construct()
    {
        $this->storage = StorageFactory::create();
        $this->uploadValidator = new UploadValidator();
        $this->identifierStrategy = IdentifierStrategyFactory::create();
    }

    /**
     * Manage GET requests to retreive a file.
     * @param $identifier string identifier of file
     */
    public function get($identifier)
    {
        $this->validateIdentifier($identifier);

        try {
            $file = $this->storage->getFile($identifier);

            header('Content-Type: ' . $file->getType());
            $this->sendCacheHeader($file);

            echo $file->getContent();
        } catch (FileNotExistsException $e) {
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
     * Send cache headers if needed when displaying a file.
     * @param $file File file
     */
    private function sendCacheHeader($file)
    {
        $mtime = @filemtime($file->getPath());

        if ($mtime > 0) {
            $gmt_mtime = gmdate('D, d M Y H:i:s', $mtime) . ' GMT';
            $etag = sprintf('%08x-%08x', crc32($file->getPath()), $mtime);

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

            $this->storage->storeFile($identifier, $dto);
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
            $this->storage->deleteFile($identifier);
            http_response_code(204);
        } catch (FileNotExistsException $e) {
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
