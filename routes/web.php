<?php
$router->setBasePath(''); // Set this if your app is in a subdirectory

// Define routes
// Home routes
$router->map('GET', '/', 'App\Controllers\HomeController#index', 'home');
$router->map('GET', '/about', 'App\Controllers\HomeController#about', 'about');
$router->map('GET', '/contact', 'App\Controllers\HomeController#contact', 'contact');
$router->map('POST', '/contact', 'App\Controllers\HomeController#contact', 'contact_post');
$router->map('GET', '/admin', 'App\Controllers\HomeController#adminDashboard', 'admin_dashboard');
$router->map('GET', '/unauthorized', 'App\Controllers\HomeController#unauthorized', 'unauthorized');

// Static pages routes
$router->map('GET', '/contact-us', 'App\Controllers\StaticPagesController#contactUs', 'contact_us');

// Auth routes
$router->map('GET', '/login', 'App\Controllers\AuthController#loginForm', 'login');
$router->map('POST', '/login', 'App\Controllers\AuthController#login', 'login_post');
$router->map('GET', '/register', 'App\Controllers\AuthController#registerForm', 'register');
$router->map('POST', '/register', 'App\Controllers\AuthController#register', 'register_post');
$router->map('GET', '/logout', 'App\Controllers\AuthController#logout', 'logout');

// User routes
$router->map('GET', '/user/dashboard', 'App\Controllers\UserController#dashboard', 'dashboard');

// Error routes
$router->map('GET', '/errors/404', 'App\Controllers\ErrorController#error404', 'error_404');
$router->map('GET', '/errors/403', 'App\Controllers\ErrorController#error403', 'error_403');
$router->map('GET', '/errors/500', 'App\Controllers\ErrorController#error500', 'error_500');

// API routes for Axios
$router->map('POST', '/api/login', 'App\Controllers\AuthController#apiLogin', 'api_login');
$router->map('POST', '/api/logout', 'App\Controllers\AuthController#apiLogout', 'api_logout');
$router->map('GET', '/api/user', 'App\Controllers\AuthController#apiCheckUser', 'api_check_user');