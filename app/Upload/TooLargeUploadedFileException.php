<?php

namespace FilesService\Upload;

use UnexpectedValueException;

/**
 * Class TooLargeUploadedFileException.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package FilesService\Upload
 * @since   1.0.0
 */
class TooLargeUploadedFileException extends UnexpectedValueException
{
    /**
     * @var int upload limit
     */
    private $limit;

    /**
     * @var int size of the uploaded file
     */
    private $size;

    /**
     * TooLargeUploadedFileException constructor.
     *
     * @param $size int size of the uploaded file
     * @param $limit int upload limit
     */
    public function __construct($size, $limit)
    {
        parent::__construct();
        $this->size = $size;
        $this->limit = $limit;
    }

    /**
     * @return string readable limit
     */
    public function getReadableLimit()
    {
        $size = array('B', 'kB', 'MB', 'GB');
        $factor = floor((strlen($this->limit) - 1) / 3);

        return sprintf("%.2f", $this->limit / pow(1024, $factor)) . @$size[$factor];
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }
}
