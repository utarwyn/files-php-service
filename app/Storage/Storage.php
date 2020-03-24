<?php

namespace App\Storage;

use App\Upload\UploadedFile;

/**
 * Interface Storage.
 *
 * @package App\Storage
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
interface Storage
{
    /**
     * Get a document from its identifier.
     *
     * @param $identifier string identifier of the document
     * @return Document retreived document
     * @throws DocumentNotExistsException thrown if the document does not exist in the storage
     */
    public function getDocument($identifier);

    /**
     * Store a new file and generate an identifier for it.
     *
     * @param $identifier string document identifier
     * @param $document UploadedFile uploaded file to store
     * @return Document generated identifier of the document
     */
    public function storeDocument($identifier, $document);

    /**
     * Delete a document from the storage.
     *
     * @param $identifier string identifier of the document to delete
     * @throws DocumentNotExistsException thrown if the document does not exist in the storage
     */
    public function deleteDocument($identifier);
}
