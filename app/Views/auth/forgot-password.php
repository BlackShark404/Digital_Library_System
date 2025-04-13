<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Digital Library System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="/node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/public/assets/css/auth.css">
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-container row g-0">
            <!-- Image Section -->
            <div class="col-md-6 auth-image d-none d-md-block position-relative">
                <div class="position-absolute top-50 start-50 translate-middle text-white text-center p-4">

                </div>
            </div>

            <div class="col-md-6 login-form">
                <form id="forgotPasswordForm">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-3 fw-normal">Forgot Password</h1>
                        <p class="text-muted">Enter your email to reset your password</p>
                    </div>

                    <div class="mb-3">
                        <div class="input-group border border-1 rounded-3">
                            <span class="input-group-text border-end"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control form-control-with-icon" id="email" placeholder="Enter your email" required>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 mb-3" type="submit">Reset Password</button>

                    <div class="text-center">
                        <p class="text-muted">
                            Remember your password?
                            <a href="/app/views/pages/auth/login.php" class="text-primary">Back to Sign In</a>
                        </p>
                    </div>

                    <div id="resetMessage" class="alert mt-3" style="display: none;"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="/public/assets/js/auth/forgot-password.js"></script>
</body>

</html>