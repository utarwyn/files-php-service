<?php

namespace FilesService\File;

/**
 * Represents a file with a type, a path and an identifier.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package FilesService\File
 * @since   1.0.0
 */
class File
{
    /**
     * @var string content of the file
     */
    private $content;

    /**
     * @var string identifier of the file
     */
    private $identifier;

    /**
     * @var string absolute path of the file
     */
    private $path;

    /**
     * @var string mime (type) of the file
     */
    private $type;

    /**
     * File constructor.
     *
     * @param $identifier string
     * @param $path string
     * @param $type string
     * @param $content string
     */
    public function __construct($identifier, $path, $type, $content)
    {
        $this->identifier = $identifier;
        $this->path = $path;
        $this->type = $type;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
