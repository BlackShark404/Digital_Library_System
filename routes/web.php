<?php

// Define public routes
$publicRoutes = [
    '/',
    '/login',
    '/register',
    '/contact-us',
];

// Define the access control map for routes
$accessMap = [
    // Admin-only routes
    '/admin/dashboard' => ['admin'],
    '/admin/users' => ['admin'],
    '/admin/books' => ['admin'],
    '/admin/reading' => ['admin'],
    '/admin/purchases' => ['admin'],
    '/admin/logs' => ['admin'],

    // Logout route (accessible by any logged-in user)
    '/logout' => ['admin', 'user'],
];

$router->setBasePath(''); // Set this if your app is in a subdirectory

// Define routes
// Home routes
$router->map('GET', '/', 'App\Controllers\HomeController#index', 'home');
$router->map('GET', '/about', 'App\Controllers\HomeController#about', 'about');
$router->map('GET', '/contact-us', 'App\Controllers\HomeController#contactUs', 'contact');
$router->map('POST', '/contact-us', 'App\Controllers\HomeController#contactUs', 'contact_post');


// Auth routes
$router->map('GET', '/login', 'App\Controllers\AuthController#loginForm', 'login');
$router->map('POST', '/login', 'App\Controllers\AuthController#login', 'login_post');
$router->map('GET', '/register', 'App\Controllers\AuthController#registerForm', 'register');
$router->map('POST', '/register', 'App\Controllers\AuthController#register', 'register_post');
$router->map('GET', '/logout', 'App\Controllers\AuthController#logout', 'logout');

// Admin routes
$router->map('GET', '/admin/dashboard', 'App\Controllers\AdminController#adminDashboard', 'admin_dashboard');
$router->map('GET', '/admin/user-management', 'App\Controllers\AdminController#userManagement', 'user-management');

// User routes
$router->map('GET', '/user/dashboard', 'App\Controllers\UserController#dashboard', 'user_dashboard');

// Error routes
$router->map('GET', '/error/404', 'App\Controllers\ErrorController#error404', 'error_404');
$router->map('GET', '/error/403', 'App\Controllers\ErrorController#error403', 'error_403');
$router->map('GET', '/error/500', 'App\Controllers\ErrorController#error500', 'error_500');