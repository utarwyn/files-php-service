<?php

namespace App\Storage;

/**
 * Represents a document with a type, a path and an identifier.
 *
 * @package App\Storage
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
class Document
{
    /**
     * @var string content of the document
     */
    private $content;

    /**
     * @var string identifier of the document
     */
    private $identifier;

    /**
     * @var string absolute path of the document
     */
    private $path;

    /**
     * @var string mime (type) of the document
     */
    private $type;

    /**
     * Document constructor.
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
