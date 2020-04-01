<?php

namespace FilesService\File;

use UnexpectedValueException;

/**
 * Class FileNotExistsException.
 * Thrown when a file cannot be found in a storage.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package FilesService\File
 * @since   1.0.0
 */
class FileNotExistsException extends UnexpectedValueException
{
    /**
     * @var string identifier of the file that does not exist
     */
    private $identifier;

    /**
     * FileNotExistsException constructor.
     *
     * @param $identifier string identifier of the file
     */
    public function __construct($identifier)
    {
        parent::__construct();
        $this->identifier = $identifier;
    }

    /**
     * @return string identifier of the file
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
