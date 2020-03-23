<?php

namespace App\Traits;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;

trait AuthTrait
{
    public function generateAuthToken($duration = 3600)
    {
        return JWT::encode([
            'iss' => 'media_api',
            'iat' => time(),
            'exp' => time() + $duration
        ], $this->getJWTSecretKey());
    }

    public function verifyAndDecodeAuthToken($jwt)
    {
        try {
            return JWT::decode($jwt, $this->getJWTSecretKey(), array('HS256'));
        } catch (SignatureInvalidException $e) {
            return null;
        } catch (ExpiredException $e) {
            return null;
        }
    }

    private function getJWTSecretKey()
    {
        return getenv('JWT_SECRET_TOKEN');
    }
}
