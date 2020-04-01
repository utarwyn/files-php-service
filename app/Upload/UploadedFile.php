<?php

namespace FilesService\Upload;

/**
 * Class UploadedFile.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package FilesService\Upload
 * @since   1.0.0
 */
class UploadedFile
{
    /**
     * @var int upload error code, zero if no error
     */
    private $error;

    /**
     * @var int size of the uploaded file, in bytes
     */
    private $size;

    /**
     * @var string temporary path of the uploaded file
     */
    private $tmpName;

    /**
     * @var string mime type of the uploaded file
     */
    private $type;

    /**
     * UploadedFile constructor.
     *
     * @param $type string uploaded file type
     * @param $tmpName string uploaded file temporary path
     * @param $size int uploaded file size
     * @param $error int upload error code
     */
    public function __construct($type, $tmpName, $size, $error)
    {
        $this->type = $type;
        $this->tmpName = $tmpName;
        $this->size = $size;
        $this->error = $error;
    }

    /**
     * @return int
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getTmpName()
    {
        return $this->tmpName;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
