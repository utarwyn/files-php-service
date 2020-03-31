<?php

namespace MediasService\Media;

/**
 * Represents a media with a type, a path and an identifier.
 *
 * @package MediasService\Media
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
class Media
{
    /**
     * @var string content of the media
     */
    private $content;

    /**
     * @var string identifier of the media
     */
    private $identifier;

    /**
     * @var string absolute path of the media
     */
    private $path;

    /**
     * @var string mime (type) of the media
     */
    private $type;

    /**
     * Media constructor.
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
