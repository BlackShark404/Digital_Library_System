<?php
$router->setBasePath(''); // Set this if your app is in a subdirectory

// Define routes
// Home routes
$router->map('GET', '/', 'App\Controllers\HomeController#index', 'home');
$router->map('GET', '/about', 'App\Controllers\HomeController#about', 'about');
$router->map('GET', '/contact-us', 'App\Controllers\HomeController#contactUs', 'contact');
$router->map('POST', '/contact-us', 'App\Controllers\HomeController#contactUs', 'contact_post');
$router->map('GET', '/privacy', 'App\Controllers\HomeController#adminDashboard', 'admin_dashboard');

// Static pages routes
$router->map('GET', '/contact-us', 'App\Controllers\StaticPagesController#contactUs', 'contact_us');

// Auth routes
$router->map('GET', '/login', 'App\Controllers\AuthController#showLoginForm', 'login');
$router->map('POST', '/login', 'App\Controllers\AuthController#login', 'login_post');
$router->map('GET', '/register', 'App\Controllers\AuthController#showRegisterForm', 'register');
$router->map('POST', '/register', 'App\Controllers\AuthController#register', 'register_post');
$router->map('GET', '/logout', 'App\Controllers\AuthController#logout', 'logout');

// User routes
$router->map('GET', '/user/dashboard', 'App\Controllers\UserController#dashboard', 'dashboard');

// Error routes
$router->map('GET', '/error/404', 'App\Controllers\ErrorController#error404', 'error_404');
$router->map('GET', '/error/403', 'App\Controllers\ErrorController#error403', 'error_403');
$router->map('GET', '/error/500', 'App\Controllers\ErrorController#error500', 'error_500');

$router->map('GET', '/admin/dashboard', 'App\Controllers\AuthController#adminDashboard', 'test2');
