<?php

namespace MediasService\Storage;

/**
 * Class StorageFactory.
 *
 * @package MediasService\Storage
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
class StorageFactory
{
    private function __construct()
    {
        // Factory class
    }

    /**
     * @return Storage storage wrapper to use
     */
    public static function create()
    {
        return new FlatStorage();
    }
}
