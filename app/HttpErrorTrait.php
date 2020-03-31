<?php

namespace MediasService;

/**
 * Methods to send HTTP errors with a custom body.
 *
 * @author  Maxime Malgorn <maxime.malgorn@laposte.net>
 * @license MIT
 * @package MediasService
 * @since   1.0.0
 */
trait HttpErrorTrait
{
    public function notFound($name = 'NOT_FOUND', $message = 'Resource not found')
    {
        $this->error(404, $name, $message);
    }

    protected function authError($name = 'AUTH_ERROR', $message = 'Authorization error')
    {
        $this->error(401, $name, $message);
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

    protected function badRequest($name = 'BAD_REQUEST', $message = 'Bad request')
    {
        $this->error(400, $name, $message);
    }
}
