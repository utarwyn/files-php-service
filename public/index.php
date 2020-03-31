<?php

use Bramus\Router\Router;
use MediasService\Auth\AuthController;
use MediasService\Controller;
use MediasService\Media\MediaController;

define('DS', DIRECTORY_SEPARATOR);
define('BASE', dirname(__DIR__));

require BASE . '/vendor/autoload.php';

// Load custom environment variables
$dotenv = Dotenv\Dotenv::createImmutable(BASE);
$dotenv->load();

// Load router with custom routes
$router = new Router();
$controller = new MediaController();

$router->set404([new Controller(), 'notFound']);

$router->post('/token', [new AuthController(), 'token']);

$router->get('/([\w-]+)', [$controller, 'get']);
$router->post('/', [$controller, 'post']);
$router->delete('/([\w-]+)', [$controller, 'delete']);

$router->run();
