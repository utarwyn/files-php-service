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

    protected function protectRoute()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $this->authError('AUTH_ERROR',
                'This resource is protected. An authorization is required to get access.');
        }

        $token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);
        $decoded = $this->verifyAndDecodeAuthToken($token);

        if (is_null($decoded)) {
            $this->authError('AUTH_ERROR', 'Invalid or expired access token.');
        }
    }

    protected function getPost()
    {
        $input = file_get_contents('php://input');

        if (!empty($input)) {
            return json_decode($input, true);
        } else {
            return $_POST;
        }
    }

    protected function authError($name = 'AUTH_ERROR', $message = 'Authorization error')
    {
        $this->error(401, $name, $message);
    }

    protected function badRequest($name = 'BAD_REQUEST', $message = 'Bad request')
    {
        $this->error(400, $name, $message);
    }

    protected function error($statusCode = 500, $name = 'API_ERROR', $message = 'An internal error occured')
    {
        http_response_code($statusCode);

        $this->json([
            'error' => $name,
            'message' => $message
        ]);
        exit();
    }

    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function notFound($name = 'NOT_FOUND', $message = 'Resource not found')
    {
        $this->error(404, $name, $message);
    }
}
