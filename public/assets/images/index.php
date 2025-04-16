<?php
// index.php - Main entry point for the application

// Autoload dependencies
require_once __DIR__ . '/../vendor/autoload.php';

// Use necessary classes
use AltoRouter as Router;
use Core\AuthMiddleware;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Initialize router
$router = new Router();

// Include route definitions
require_once __DIR__ . '/../routes/web.php';

// Middleware to handle authentication
AuthMiddleware::handle($accessMap, $publicRoutes);

// Match the current request to a route
$match = $router->match();

if ($match) {
    // Split the controller and method
    list($controller, $method) = explode('#', $match['target']);

    // Instantiate the controller
    $controllerInstance = new $controller();

    // Call the method with parameters
    call_user_func_array([$controllerInstance, $method], $match['params']);
} else {
    // No route match, send 404
    header("HTTP/1.0 404 Not Found", 404);
}
