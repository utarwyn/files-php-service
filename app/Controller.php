<?php

namespace FilesService;

use FilesService\Auth\Token\AuthTokenInvalidException;
use FilesService\Auth\Token\AuthTokenStrategyFactory;

/**
 * Main Controller, defines basic behaviors for others controllers.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package FilesService
 * @since   1.0.0
 */
class Controller
{
    use HttpErrorTrait;

    protected function protectRoute()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $this->authError(
                'AUTH_ERROR',
                'This resource is protected. An authorization is required to get access.'
            );
        }

        $token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);

        try {
            AuthTokenStrategyFactory::create()->decode($token);
        } catch (AuthTokenInvalidException $e) {
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

    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
