<?php

namespace App\Controllers;

use App\Controller;
use App\Storage\Document;
use App\Storage\DocumentNotExistsException;
use App\Storage\FlatStorage;
use App\Storage\Storage;
use App\Util\IdentifierStrategy;
use App\Util\UniqueIdentifierStrategy;

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
     * DocumentController constructor.
     */
    public function __construct()
    {
        $this->identifierStrategy = new UniqueIdentifierStrategy();
        $this->storage = new FlatStorage();
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
        // TODO write this route
    }

    public function delete($identifier)
    {
        $this->protectRoute();
        $this->validateIdentifier($identifier);

        // TODO write this route
        $this->json(['identifier' => $identifier]);
    }
}
