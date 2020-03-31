<?php

namespace MediasService\Storage;

use MediasService\Media\Media;
use MediasService\Media\MediaNotExistsException;
use MediasService\Upload\UploadedFile;

/**
 * Interface Storage.
 *
 * @package MediasService\Storage
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
interface Storage
{
    /**
     * Get a media from its identifier.
     *
     * @param $identifier string identifier of the media
     * @return Media retreived media
     * @throws MediaNotExistsException thrown if the media does not exist in the storage
     */
    public function getMedia($identifier);

    /**
     * Store a new file and generate an identifier for it.
     *
     * @param $identifier string media identifier
     * @param $media UploadedFile uploaded file to store
     * @return Media generated identifier of the media
     */
    public function storeMedia($identifier, $media);

    /**
     * Delete a media from the storage.
     *
     * @param $identifier string identifier of the media to delete
     * @throws MediaNotExistsException thrown if the media does not exist in the storage
     */
    public function deleteMedia($identifier);
}
