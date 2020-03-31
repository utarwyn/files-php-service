<?php

namespace MediasService\Auth\Token;

/**
 * Class AuthTokenStrategyFactory.
 *
 * @package MediasService\Auth\Token
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
class AuthTokenStrategyFactory
{
    private function __construct()
    {
        // Factory class
    }

    /**
     * @return AuthTokenStrategy auth token strategy to use
     */
    public static function create()
    {
        return new JWTAuthTokenStrategy();
    }
}
