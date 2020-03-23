<?php

namespace App;

class Controller
{

    public function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function badRequest($error_code = 'BAD_REQUEST', $description = null)
    {
        http_response_code(400);
        $this->json([
            'error' => $error_code,
            'description' => $description
        ]);

        exit();
    }

}
