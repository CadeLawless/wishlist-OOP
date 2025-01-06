<?php

// Include the Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use Middleware\AuthMiddleware;
use Core\Router;

// Run middleware before routing
$authMiddleware = new AuthMiddleware();
$authMiddleware->handle();

$requestUrl = $_SERVER['REQUEST_URI'];

// Strip the base directory
$requestUrl = str_replace('/wishlist1', '', $requestUrl);

$router = new Router();
$router->add(['/', '/index', '/index.php'], [App\Controllers\HomeController::class, 'index']);
$router->add('/users', [App\Controllers\UserController::class, 'list']);
$router->dispatch($requestUrl);

?>