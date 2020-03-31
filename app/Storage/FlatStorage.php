<?php

namespace MediasService\Storage;

use MediasService\Media\Media;
use MediasService\Media\MediaNotExistsException;

/**
 * Class FlatStorage.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package MediasService\Storage
 * @since   1.0.0
 */
class FlatStorage implements Storage
{
    /**
     * @var string root directory for medias
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
    public function getMedia($identifier)
    {
        $path = $this->getFilePath($identifier);

        if (file_exists($path)) {
            $type = mime_content_type($path);
            $handle = fopen($path, "r");
            $content = fread($handle, filesize($path));
            fclose($handle);

            return new Media($identifier, $path, $type, $content);
        } else {
            throw new MediaNotExistsException($identifier);
        }
    }

    /**
     * Retreive a file path based on the media identifier.
     *
     * @param $identifier string identifier of the media to retreive
     * @return string file path of the media
     */
    private function getFilePath($identifier)
    {
        return $this->baseDir . DS . $identifier;
    }

    /**
     * @inheritDoc
     */
    public function storeMedia($identifier, $media)
    {
        move_uploaded_file($media->getTmpName(), $this->getFilePath($identifier));
    }

    /**
     * @inheritDoc
     */
    public function deleteMedia($identifier)
    {
        $path = $this->getFilePath($identifier);

        if (file_exists($path)) {
            unlink($path);
        } else {
            throw new MediaNotExistsException($identifier);
        }
    }
}
