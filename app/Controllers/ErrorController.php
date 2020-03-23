<?php

namespace App\Controllers;

class ErrorController
{
    public function error404()
    {
        http_response_code(404);
        echo '404 Not found';
    }
}
