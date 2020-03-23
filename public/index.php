<?php

use App\Controllers\DocumentController;
use App\Controllers\ErrorController;
use App\Controllers\OAuthController;
use Bramus\Router\Router;

define('BASE', dirname(__DIR__));

require BASE . '/vendor/autoload.php';

// Load custom environment variables
$dotenv = Dotenv\Dotenv::createImmutable(BASE);
$dotenv->load();

// Load router with custom routes
$router = new Router();

$router->set404([new ErrorController(), 'error404']);

$router->post('token', [new OAuthController(), 'token']);
$router->mount('/d', function () use ($router) {
    $controller = new DocumentController();

    $router->get('/(\w+)', [$controller, 'get']);
    $router->post('/', [$controller, 'post']);
    $router->delete('/(\w+)', [$controller, 'delete']);
});

$router->run();
