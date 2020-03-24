<?php

use App\Controller;
use App\Controllers\DocumentController;
use App\Controllers\OAuthController;
use Bramus\Router\Router;

define('DS', DIRECTORY_SEPARATOR);
define('BASE', dirname(__DIR__));

require BASE . '/vendor/autoload.php';

// Load custom environment variables
$dotenv = Dotenv\Dotenv::createImmutable(BASE);
$dotenv->load();

// Load router with custom routes
$router = new Router();
$controller = new DocumentController();

$router->set404([new Controller(), 'notFound']);

$router->post('/token', [new OAuthController(), 'token']);

$router->get('/([\w-]+)', [$controller, 'get']);
$router->post('/', [$controller, 'post']);
$router->delete('/([\w-]+)', [$controller, 'delete']);

$router->run();
