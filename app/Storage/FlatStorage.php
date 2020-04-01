<?php

namespace FilesService\Storage;

use FilesService\File\File;
use FilesService\File\FileNotExistsException;

/**
 * Class FlatStorage.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package FilesService\Storage
 * @since   1.0.0
 */
class FlatStorage implements Storage
{
    /**
     * @var string root directory for files
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
    public function getFile($identifier)
    {
        $path = $this->getFilePath($identifier);

        if (file_exists($path)) {
            $type = mime_content_type($path);
            $handle = fopen($path, "r");
            $content = fread($handle, filesize($path));
            fclose($handle);

            return new File($identifier, $path, $type, $content);
        } else {
            throw new FileNotExistsException($identifier);
        }
    }

    /**
     * Retreive a file path based on the file identifier.
     *
     * @param $identifier string identifier of the file to retreive
     * @return string file path of the file
     */
    private function getFilePath($identifier)
    {
        return $this->baseDir . DS . $identifier;
    }

    /**
     * @inheritDoc
     */
    public function storeFile($identifier, $uploadedFile)
    {
        move_uploaded_file($uploadedFile->getTmpName(), $this->getFilePath($identifier));
    }

    /**
     * @inheritDoc
     */
    public function deleteFile($identifier)
    {
        $path = $this->getFilePath($identifier);

        if (file_exists($path)) {
            unlink($path);
        } else {
            throw new FileNotExistsException($identifier);
        }
    }
}
