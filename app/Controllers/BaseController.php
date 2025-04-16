<?php

namespace App\Controllers;

use Config\Database;

class BaseController
{
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getDb() {
        return $this->db;
    }

    protected function getViewPath(string $relativePath): string {
        $path = __DIR__ . "/../Views/{$relativePath}.php";

        if (!file_exists($path)) {
            $this->renderError("View not found: {$relativePath}", 404);
        }

        return $path;
    }

    protected function getSidebarPath(): string
    {
        $role = $_SESSION['user_role'] ?? 'user';
        // FIXED: Swapped admin and user sidebar paths (they were reversed)
        return ($role === 'admin') ? 'includes/admin-sidebar' : 'includes/user-sidebar';
    }

    protected function render($view, $data = []) {
        // Start output buffering only once
        ob_start();

        // Get paths first without including any files
        $viewPath = $this->getViewPath($view);
        
        $headerPath = $this->getViewPath("includes/header");
        $footerPath = $this->getViewPath("includes/footer");
        
        // Get sidebar path as string, not resolved path
        $sidebarRelativePath = $this->getSidebarPath();
        $sidebarPath = $this->getViewPath($sidebarRelativePath);

        $data['headerPath'] = $headerPath;
        $data['sidebarPath'] = $sidebarPath;
        $data['footerPath'] = $footerPath;

        extract($data);
        
        // Include the files
        
        include $viewPath;

        $content = ob_get_clean();
        echo $content;
    }

    protected function renderError($message, $statusCode = 500) {
        http_response_code($statusCode);
        $errorView = __DIR__ . "/../Views/error/$statusCode.php";

        if (file_exists($errorView)) {
            // Avoid recursion: don't use getViewPath here
            extract(['message' => $message]);
            ob_start();
            include $errorView;
            $content = ob_get_clean();
            echo $content;
        } else {
            // Fallback plain error message
            echo "<h1>Error: $statusCode</h1><p>$message</p>";
        }

        exit;
    }


    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
    

    protected function loadModel($model) {
        $modelClass = "App\\Models\\$model";

        if (class_exists($modelClass)) {
            return new $modelClass();
        } else {
            $this->renderError("Model class not found: $modelClass", 500);
        }
    }

    // ✅ Check if request is from Axios
    protected function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    // ✅ Respond with JSON (generic)
    protected function json($data = [], $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // ✅ Respond with JSON success (standardized)
    protected function jsonSuccess($data = [], $message = 'Success', $statusCode = 200) {
        $this->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    // ✅ Respond with JSON error (standardized)
    protected function jsonError($message = 'An error occurred', $statusCode = 400, $data = []) {
        $this->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    // ✅ Parse JSON from request body
    protected function getJsonInput(): array {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    // ✅ Input helpers
    protected function request($key = null, $default = null) {
        $request = array_merge($_GET, $_POST);
        if ($key) {
            return $request[$key] ?? $default;
        }
        return $request;
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function sanitize($input, $type = 'text')
    {
        // Handle arrays recursively
        if (is_array($input)) {
            return array_map(function($item) use ($type) {
                return $this->sanitize($item, $type);
            }, $input);
        }
        
        // Handle objects
        if (is_object($input)) {
            // For objects that can be cast to string
            if (method_exists($input, '__toString')) {
                return $this->sanitize((string)$input, $type);
            }
            // Return original for other objects, could log a warning here
            return $input;
        }
        
        // Return null/bool values as is
        if (is_null($input) || is_bool($input)) {
            return $input;
        }
        
        // Convert to string if numeric
        if (is_numeric($input)) {
            $input = (string)$input;
        }
        
        // Sanitize based on data type
        switch ($type) {
            case 'email':
                $input = filter_var(trim($input), FILTER_SANITIZE_EMAIL);
                break;
                
            case 'url':
                $input = filter_var(trim($input), FILTER_SANITIZE_URL);
                break;
                
            case 'int':
                return filter_var($input, FILTER_VALIDATE_INT) ?? 0;
                
            case 'float':
                return filter_var($input, FILTER_VALIDATE_FLOAT) ?? 0.0;
                
            case 'html':
                // Use HTML Purifier or similar library for real-world scenarios
                $input = $this->purifyHtml($input);
                break;
                
            case 'plain':
                // Remove all HTML, no entities conversion
                $input = trim(strip_tags($input));
                break;
                
            case 'text':
            default:
                // Default behavior: strip tags and encode entities
                $input = htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
        }
        
        return $input;
    }

    protected function sanitizeWithRules(array $input, array $rules, $defaultType = 'text'): array
    {
        $sanitized = [];

        foreach ($input as $key => $value) {
            $type = $rules[$key] ?? $defaultType;
            $sanitized[$key] = $this->sanitize($value, $type);
        }

        return $sanitized;
    }


    /**
     * Placeholder for HTML purification
     * In a real-world scenario, you would use a library like HTML Purifier
     */
    protected function purifyHtml($html)
    {
        // This is a simplified placeholder - use a proper HTML purifier in production
        // Example with HTML Purifier would be:
        // $purifier = new HTMLPurifier($config);
        // return $purifier->purify($html);
        
        // Basic fallback (NOT recommended for production):
        $allowed_tags = '<p><br><strong><em><ul><ol><li><a><h1><h2><h3><table><tr><td><th>';
        return htmlspecialchars(strip_tags(trim($html), $allowed_tags), ENT_QUOTES, 'UTF-8');
    }

}
