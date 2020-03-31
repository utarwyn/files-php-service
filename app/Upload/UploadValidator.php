<?php

namespace MediasService\Upload;

/**
 * Class UploadValidator used to validate an uploaded file.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package MediasService\Upload
 * @since   1.0.0
 */
class UploadValidator
{
    /**
     * @var int size in bytes that uploaded files cannot exceed
     */
    private $limit;

    /**
     * @var string[] array of types allowed
     */
    private $allowedTypes;

    /**
     * UploadValidator constructor.
     */
    public function __construct()
    {
        $this->limit = intval(getenv('FILE_MAX_SIZE'));
        $this->allowedTypes = preg_split('/,/', getenv('FILE_AUTHORIZED_TYPES'));
    }

    /**
     * Validate an uploaded file.
     *
     * @param $file UploadedFile file to validate
     * @throws TooLargeUploadedFileException thrown if the uploaded file is too large
     * @throws WrongTypeUploadedFileException thrown if the uploaded file has a wrong type
     */
    public function validate($file)
    {
        if ($file->getSize() > $this->limit) {
            throw new TooLargeUploadedFileException($file->getSize(), $this->limit);
        }

        if (!in_array($file->getType(), $this->allowedTypes, true)) {
            throw new WrongTypeUploadedFileException($file->getType());
        }
    }
}
