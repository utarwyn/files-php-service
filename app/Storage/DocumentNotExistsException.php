<?php

namespace App\Storage;

use UnexpectedValueException;

/**
 * Class DocumentNotExistsException.
 * Thrown when a document cannot be found in a storage.
 *
 * @package App\Storage
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
class DocumentNotExistsException extends UnexpectedValueException
{
    /**
     * @var string identifier of the document that does not exist
     */
    private $identifier;

    /**
     * DocumentNotExistsException constructor.
     *
     * @param $identifier string identifier of the document
     */
    public function __construct($identifier)
    {
        parent::__construct();
        $this->identifier = $identifier;
    }

    /**
     * @return string identifier of the document
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
