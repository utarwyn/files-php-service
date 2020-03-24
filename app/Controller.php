<?php

namespace App;

use App\Traits\AuthTrait;

/**
 * Main Controller, defines basic behaviors for others controllers.
 *
 * @package App
 * @author Maxime Malgorn <maxime.malgorn@laposte.net>
 * @since 1.0.0
 */
class Controller
{
    use AuthTrait;

    public function protectRoute()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $this->badRequest(
                'AUTH_NEEDED',
                'You need to provide an access token to access this route.'
            );
        }

        $token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);
        $decoded = $this->verifyAndDecodeAuthToken($token);

        if (is_null($decoded)) {
            http_response_code(401);
            $this->error('AUTH_ERROR', 'Invalid or expired access token.');
        }
    }

    public function badRequest($error_code = 'BAD_REQUEST', $description = 'Bad request')
    {
        http_response_code(400);
        $this->error($error_code, $description);
    }

    public function error($error_code = 'API_ERROR', $description = 'An internal error occured')
    {
        if (http_response_code() == 200) {
            http_response_code(500);
        }

        $this->json([
            'error' => $error_code,
            'description' => $description
        ]);
        exit();
    }

    public function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function notFound($error_code = 'NOT_FOUND', $description = 'Resource not found')
    {
        http_response_code(404);
        $this->error($error_code, $description);
    }
}
