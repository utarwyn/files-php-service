<?php

namespace FilesService\Storage;

use FilesService\File\File;
use FilesService\File\FileNotExistsException;
use FilesService\Upload\UploadedFile;

/**
 * Interface Storage.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package FilesService\Storage
 * @since   1.0.0
 */
interface Storage
{
    /**
     * Get a file from its identifier.
     *
     * @param $identifier string identifier of the file
     * @return File retreived file
     * @throws FileNotExistsException thrown if the file does not exist in the storage
     */
    public function getFile($identifier);

    /**
     * Store a new file and generate an identifier for it.
     *
     * @param $identifier string file identifier
     * @param $uploadedFile UploadedFile uploaded file to store
     * @return File generated identifier of the file
     */
    public function storeFile($identifier, $uploadedFile);

    /**
     * Delete a file from the storage.
     *
     * @param $identifier string identifier of the file to delete
     * @throws FileNotExistsException thrown if the file does not exist in the storage
     */
    public function deleteFile($identifier);
}
