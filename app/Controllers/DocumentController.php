<?php

namespace App\Controllers;

use App\Controller;

class DocumentController extends Controller
{
    public function get($uuid)
    {
        // TODO write this route
        $this->json(['uuid' => $uuid]);
    }

    public function post()
    {
        $this->protectRoute();
        // TODO write this route
    }

    public function delete($uuid)
    {
        $this->protectRoute();
        $this->json(['uuid' => $uuid]);
    }
}
