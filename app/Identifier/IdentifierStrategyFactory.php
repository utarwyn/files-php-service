<?php

namespace MediasService\Identifier;

/**
 * Class IdentifierStrategyFactory.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package MediasService\Identifier
 * @since   1.0.0
 */
class IdentifierStrategyFactory
{
    private function __construct()
    {
        // Factory class
    }

    /**
     * @return IdentifierStrategy identifier strategy to use
     */
    public static function create()
    {
        return new UniqueIdentifierStrategy();
    }
}
