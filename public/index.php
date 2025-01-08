<?php

ini_set("display_errors", 1);

session_start();

// Include the Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use App\Models\User;
use Middleware\AuthMiddleware;

$requestUrl = $_SERVER['REQUEST_URI'];

// Strip the base directory
$requestUrl = str_replace('/wishlist1', '', $requestUrl);

$router = new Router();
$router->add(['/', '/index'], [App\Controllers\HomeController::class, 'index']);
$router->add(['/login'], [App\Controllers\LoginController::class, 'index']);

if(in_array($requestUrl, ["/login", "/create-an-account"])){
    $router->dispatch($requestUrl);
}else{
    $user = new User();

    // Run middleware before routing
    $authMiddleware = new AuthMiddleware();
    $authMiddleware->handle(user: $user);
    $router->dispatch($requestUrl);
}

?>