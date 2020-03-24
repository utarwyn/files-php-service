<?php

namespace App\Storage;

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
     * Store a new document and generate an identifier for it.
     *
     * @param $document string content of the document to store
     * @return Document generated identifier of the document
     */
    public function storeDocument($document);

    /**
     * Delete a document from the storage.
     *
     * @param $identifier string identifier of the document to delete
     * @return boolean true if deleted, false otherwise
     * @throws DocumentNotExistsException thrown if the document does not exist in the storage
     */
    public function deleteDocument($identifier);
}
