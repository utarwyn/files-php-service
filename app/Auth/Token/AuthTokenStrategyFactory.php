<?php

namespace FilesService\Auth\Token;

/**
 * Class AuthTokenStrategyFactory.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package FilesService\Auth\Token
 * @since   1.0.0
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
