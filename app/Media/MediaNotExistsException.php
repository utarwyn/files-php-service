<?php

namespace MediasService\Media;

use UnexpectedValueException;

/**
 * Class MediaNotExistsException.
 * Thrown when a media cannot be found in a storage.
 *
 * @package MediasService\Media
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
class MediaNotExistsException extends UnexpectedValueException
{
    /**
     * @var string identifier of the media that does not exist
     */
    private $identifier;

    /**
     * MediaNotExistsException constructor.
     *
     * @param $identifier string identifier of the media
     */
    public function __construct($identifier)
    {
        parent::__construct();
        $this->identifier = $identifier;
    }

    /**
     * @return string identifier of the media
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
