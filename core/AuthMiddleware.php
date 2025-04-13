<?php

namespace Core;

class AuthMiddleware
{
    
    public static function requireLogin(string $redirectTo = '/login'): void
    {

        if (!isset($_SESSION['user_id'])) {
            header("Location: $redirectTo");
            exit;
        }
    }

    public static function requireGuest(string $redirectTo = 'user/dashboard'): void
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: $redirectTo");
            exit;
        }
    }

    public static function logout(string $redirectTo = '/login'): void
    {
        session_unset();
        session_destroy();
        header("Location: $redirectTo");
        exit;
    }

    public static function requireRole(array $allowedRoles = [], string $redirectTo = '/error/403'): void
    {
        if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], $allowedRoles)) {
            header("Location: $redirectTo");
            exit;
        }
    }

    public static function handle(array $accessMap = [], array $publicRoutes = []): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Check if the route is public
        foreach ($publicRoutes as $route) {
            if (preg_match("#^$route$#", $requestUri)) {
                return;
            }
        }

        // Require login for everything else
        self::requireLogin();

        // Check for route-based role access
        foreach ($accessMap as $route => $allowedRoles) {
            if (preg_match("#^$route$#", $requestUri)) {
                self::requireRole($allowedRoles);
                return;
            }
        }
    }
}
