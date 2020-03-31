<?php

namespace MediasService\Upload;

use UnexpectedValueException;

/**
 * Class WrongTypeUploadedFileException.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package MediasService\Upload
 * @since   1.0.0
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
