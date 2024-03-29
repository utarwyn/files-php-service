<?php

namespace FilesService\Auth\Token;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;

/**
 * JWTAuthTokenStrategy based on the AuthTokenStrategy.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package FilesService\Auth\Token
 * @since   1.0.0
 */
class JWTAuthTokenStrategy implements AuthTokenStrategy
{
    /**
     * @var string secret used to generate/decode a token.
     */
    private $secret;

    /**
     * JWTAuthTokenStrategy constructor.
     */
    public function __construct()
    {
        $this->secret = getenv('JWT_SECRET_TOKEN');
    }

    public function generate($duration = 3600)
    {
        return JWT::encode([
            'iss' => 'file_api',
            'iat' => time(),
            'exp' => time() + $duration
        ], $this->secret);
    }

    public function decode($token)
    {
        try {
            return JWT::decode($token, $this->secret, array('HS256'));
        } catch (SignatureInvalidException $e) {
            throw new AuthTokenInvalidException($token);
        } catch (ExpiredException $e) {
            throw new AuthTokenInvalidException($token);
        }
    }
}
