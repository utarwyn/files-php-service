<?php

namespace App\Controllers;

use App\Controller;
use App\Identifier\IdentifierStrategy;
use App\Identifier\UniqueIdentifierStrategy;
use App\Storage\Document;
use App\Storage\DocumentNotExistsException;
use App\Storage\FlatStorage;
use App\Storage\Storage;
use App\Upload\TooLargeUploadedFileException;
use App\Upload\UploadedFile;
use App\Upload\UploadValidator;
use App\Upload\WrongTypeUploadedFileException;

/**
 * Class DocumentController.
 *
 * @package App\Controllers
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
class DocumentController extends Controller
{
    /**
     * @var Storage storage wrapper to manage documents
     */
    private $storage;

    /**
     * @var IdentifierStrategy strategy class to manage document identifiers
     */
    private $identifierStrategy;

    /**
     * @var UploadValidator the upload validator
     */
    private $uploadValidator;

    /**
     * DocumentController constructor.
     */
    public function __construct()
    {
        $this->storage = new FlatStorage();
        $this->uploadValidator = new UploadValidator();
        $this->identifierStrategy = new UniqueIdentifierStrategy();
    }

    /**
     * Manage GET requests to retreive a document.
     * @param $identifier string identifier of document
     */
    public function get($identifier)
    {
        $this->validateIdentifier($identifier);

        try {
            $document = $this->storage->getDocument($identifier);

            header('Content-Type: ' . $document->getType());
            $this->sendCacheHeader($document);

            echo $document->getContent();
        } catch (DocumentNotExistsException $e) {
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
     * Send cache headers if needed when displaying a document.
     * @param $document Document document
     */
    private function sendCacheHeader($document)
    {
        $mtime = @filemtime($document->getPath());

        if ($mtime > 0) {
            $gmt_mtime = gmdate('D, d M Y H:i:s', $mtime) . ' GMT';
            $etag = sprintf('%08x-%08x', crc32($document->getPath()), $mtime);

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
                $file['type'], $file['tmp_name'],
                $file['size'], $file['error']
            );

            $this->uploadValidator->validate($dto);
            $identifier = $this->identifierStrategy->generate();

            $this->storage->storeDocument($identifier, $dto);
            echo $identifier;
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
            $this->storage->deleteDocument($identifier);
            http_response_code(204);
        } catch (DocumentNotExistsException $e) {
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
        if (!isset($_FILES['file']['type']) || !isset($_FILES['file']['tmp_name'])
            || !isset($_FILES['file']['size']) || !isset($_FILES['file']['error'])) {
            $this->badRequest(
                'UPLOADED_FILE_INVALID',
                'The uploaded file object is invalid.'
            );
        }
    }
}
