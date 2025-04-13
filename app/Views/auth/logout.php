<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Redirect to login page
$redirect_url = 'login.php'; // Adjust this to your login page
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Digital Library System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!--    Icons -->
    <link rel="stylesheet" href="/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/node_modules/@fortawesome/fontawesome-free/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/public/assets/css/auth.css">

</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-container container">
            <div class="row">
                <div class="col-12">
                    <div class="login-form text-center">
                        <div class="mb-4">
                            <i class="bi bi-box-arrow-right text-primary" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="mb-3">You've Been Logged Out</h2>
                        <p class="text-muted mb-4">Thank you for using our application. We hope to see you again soon!</p>

                        <div class="d-grid">
                            <a href="<?php echo htmlspecialchars($redirect_url); ?>" class="btn btn-primary">
                                <i class="bi bi-door-open me-2"></i>Return to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional, but recommended) -->
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>