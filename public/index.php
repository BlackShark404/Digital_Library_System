<?php
// index.php - Main entry point for the application

use Core\Session;

require __DIR__ . '/../vendor/autoload.php';

session_start();

Session::set("user_id", 123);
Session::set("user_role", "user");

use Dotenv\Dotenv;
use Core\AuthMiddleware;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$publicRoutes = [
    '/',
    '/login',
    '/register',
];

$accessMap = [
    // Admin-only routes
    '/admin/dashboard' => ['admin'],
    '/admin/users' => ['admin'],
    '/admin/books' => ['admin'],
    '/admin/reading' => ['admin'],
    '/admin/purchases' => ['admin'],
    '/admin/logs' => ['admin'],
    
    // Shared routes (if any)
    '/dashboard' => ['admin', 'user'],

    // Logout route (any logged-in role can use)
    '/logout' => ['admin', 'user'],
];

AuthMiddleware::handle($accessMap, $publicRoutes);

use AltoRouter as Router;

// Initialize router
$router = new Router();

require_once __DIR__. '/../routes/web.php';

// Match the current request
$match = $router->match();

if ($match) {
    // Split the controller and method
    list($controller, $method) = explode('#', $match['target']);

    // Instantiate controller
    $controllerInstance = new $controller();

    // Call the method with parameters
    call_user_func_array([$controllerInstance, $method], $match['params']);
} else {
    // No route match, send 404
    header("HTTP/1.0 404 Not Found", 404);
}
