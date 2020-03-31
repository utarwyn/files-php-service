<?php

namespace MediasService\Auth\Token;

use UnexpectedValueException;

/**
 * Class AuthTokenInvalidException.
 * Thrown when a token strategy object cannot decode an authorization token.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package MediasService\Auth\Token
 * @since   1.0.0
 */
class AuthTokenInvalidException extends UnexpectedValueException
{
    /**
     * @var string invalid token
     */
    private $token;

    /**
     * AuthTokenInvalidException constructor.
     *
     * @param $token string size of the uploaded file
     */
    public function __construct($token)
    {
        parent::__construct();
        $this->token = $token;
    }

    /**
     * @return string invalid token
     */
    public function getToken()
    {
        return $this->token;
    }
}
