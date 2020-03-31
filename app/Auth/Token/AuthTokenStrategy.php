<?php

namespace MediasService\Auth\Token;

/**
 * Interface AuthTokenStrategy.
 *
 * @package MediasService\Auth\Token
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
interface AuthTokenStrategy
{
    /**
     * Generate a new token based on this strategy.
     *
     * @param int $duration time in seconds during which the token will be valid
     * @return string generated identifier
     */
    public function generate($duration = 3000);

    /**
     * Validate and decode a token based on this strategy.
     *
     * @param $token string token to validate and decode
     * @return object decoded token if valid
     * @throws AuthTokenInvalidException thrown when the token is invalid
     */
    public function decode($token);
}
