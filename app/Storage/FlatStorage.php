<?php

namespace App\Storage;

/**
 * Class FlatStorage.
 *
 * @package App\Storage
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
class FlatStorage implements Storage
{
    /**
     * @var string root directory for documents and dictionary
     */
    private $baseDir;

    /**
     * FlatStorage constructor.
     */
    public function __construct()
    {
        $this->baseDir = BASE . DS . 'storage';

        // Create the storage directory if needed
        if (!file_exists($this->baseDir)) {
            mkdir($this->baseDir);
        }
    }

    /**
     * @inheritDoc
     */
    public function getDocument($identifier)
    {
        $path = $this->getFilePath($identifier);

        if (file_exists($path)) {
            $type = mime_content_type($path);
            $handle = fopen($path, "r");
            $content = fread($handle, filesize($path));
            fclose($handle);

            return new Document($identifier, $path, $type, $content);
        } else {
            throw new DocumentNotExistsException($identifier);
        }
    }

    /**
     * Retreive a file path based on the document identifier.
     *
     * @param $identifier string identifier of the document to retreive
     * @return string file path of the document
     */
    private function getFilePath($identifier)
    {
        return $this->baseDir . DS . $identifier;
    }

    /**
     * @inheritDoc
     */
    public function storeDocument($document)
    {
        // TODO: Implement createDocument() method.
    }

    /**
     * @inheritDoc
     */
    public function deleteDocument($identifier)
    {
        // TODO: Implement deleteDocument() method.
    }
}
