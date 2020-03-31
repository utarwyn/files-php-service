<?php

namespace MediasService\Identifier;

/**
 * Class IdentifierStrategyFactory.
 *
 * @package MediasService\Identifier
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
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
