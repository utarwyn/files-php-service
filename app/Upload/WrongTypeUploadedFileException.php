<?php

namespace App\Upload;

use UnexpectedValueException;

/**
 * Class WrongTypeUploadedFileException.
 *
 * @package App\Storage\Exceptions
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
class WrongTypeUploadedFileException extends UnexpectedValueException
{
    /**
     * @var string wrong type of the uploaded file
     */
    private $type;

    /**
     * WrongTypeUploadedFileException constructor.
     *
     * @param $type string wrong type of the uploaded file
     */
    public function __construct($type)
    {
        parent::__construct();
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getFileType()
    {
        return $this->type;
    }
}
