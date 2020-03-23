<?php

namespace App\Traits;

use Firebase\JWT\JWT;

trait AuthTrait
{
    public function generateToken($duration = 3600)
    {
        return JWT::encode([
            'iss' => 'media_api',
            'exp' => time() + $duration
        ], $this->getJWTSecretKey());
    }

    public function decode($jwt)
    {

    }

    private function getJWTSecretKey()
    {
        return getenv('JWT_SECRET_TOKEN');
    }
}
