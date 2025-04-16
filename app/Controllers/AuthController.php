<?php

namespace App\Controllers;

use Core\Session;
use Core\Cookie;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct() 
    {
        $this->userModel = $this->loadModel('UserModel');
    }

    public function registerForm() 
    {
        $this->render('auth/register');
    }

    public function loginForm() 
    {
        $this->render('auth/login');
    }

    public function login() 
    {
        if (!$this->isPost() || !$this->isAjax()) {
            return $this->jsonError('Invalid request method');
        }

        $data = $this->getJsonInput();
        
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $remember = isset($data['remember']);
        
        $user = $this->userModel->findByEmail($email);
        
        // Check if user exists, password is correct, and account is active
        if (!$user || 
            !$this->userModel->verifyPassword($password, $user['password']) || 
            !$user['is_active']) {
            
            if ($user && !$user['is_active']) {
                return $this->jsonError('Account is inactive');
            }
            
            return $this->jsonError('Invalid email or password');
        }

        // Update last login timestamp
        $this->userModel->updateLastLogin($user['id']);

        // Set session data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $this->userModel->getFullName($user);

        // Handle "remember me" functionality
        if ($remember) {
            $token = $this->userModel->generateRememberToken($user['id']);
            Cookie::set('remember_token', $token, 30); // 30 days
        }

        // Dynamically determine redirect URL based on role
        $redirectUrl = match ($user['role']) {
            'admin'     => '/admin/dashboard',
            'user'      => '/user/dashboard',
            default     => '/'
        };

        // Respond with JSON including redirect URL
        return $this->jsonSuccess(
            ['redirect_url' => $redirectUrl],
            'Login successful'
        );
    }

    public function register() 
    {
        if (!$this->isPost() || !$this->isAjax()) {
            return $this->jsonError('Invalid request method');
        }

        $data = $this->getJsonInput();

        // Validate required fields
        $requiredFields = ['fname', 'lname', 'email', 'password'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field] ?? '')) {
                return $this->jsonError('All fields are required');
            }
        }

        $fname = $data['fname'];
        $lname = $data['lname'];
        $email = $data['email'];
        $password = $data['password'];

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->jsonError('Invalid email format');
        }

        // Check if email already exists
        if ($this->userModel->emailExists($email)) {
            return $this->jsonError('Email already exists');
        }

        // Create the user
        $userId = $this->userModel->createUser([
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'password' => $password,
            'role' => 'user',
            'is_active' => true
        ]);

        if ($userId) {
            return $this->jsonSuccess(
                ['redirect_url' => '/login'],
                'User registered successfully'
            );
        } else {
            return $this->jsonError('Registration failed');
        }
    }

    public function logout()
    {
        // Clear "remember me" token from DB if set
        if (isset($_SESSION['user_id'])) {
            $this->userModel->clearRememberToken($_SESSION['user_id']);
        }

        // Remove session data
        Session::clear();
        Session::destroy();

        // Remove "remember me" cookie if it exists
        if (Cookie::has('remember_token')) {
            Cookie::delete('remember_token');
        }

        // Flash logout success message
        Session::flash("success", "Logout successful");

        // Redirect to login page
        $this->redirect("/login");
    }

    /**
     * Check if user is already logged in via remember token
     * Called on application startup
     */
    public function checkRememberToken()
    {
        // If already logged in, skip this check
        if (isset($_SESSION['user_id'])) {
            return;
        }
        
        // Check for remember token cookie
        if (Cookie::has('remember_token')) {
            $token = Cookie::get('remember_token');
            $user = $this->userModel->findByRememberToken($token);
            
            // If valid token and user is active
            if ($user && $user['is_active']) {
                // Update last login timestamp
                $this->userModel->updateLastLogin($user['id']);
                
                // Set session data
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $this->userModel->getFullName($user);
                
                // Generate a new token for security
                $newToken = $this->userModel->generateRememberToken($user['id']);
                Cookie::set('remember_token', $newToken, 30); // 30 days
            }
        }
    }

    /**
     * Handle password reset request form
     */
    public function forgotPasswordForm()
    {
        $this->render('auth/forgot-password');
    }

    /**
     * Process password reset request
     */
    public function forgotPassword()
    {
        if (!$this->isPost() || !$this->isAjax()) {
            return $this->jsonError('Invalid request method');
        }

        $data = $this->getJsonInput();
        $email = $data['email'] ?? '';
        
        $user = $this->userModel->findByEmail($email);
        
        if (!$user) {
            // Don't reveal if email exists or not for security
            Session::flash("success", "If your email is registered, you will receive password reset instructions");
            return $this->jsonSuccess(null, 'Reset instructions sent if email exists');
        }
        
        // Here you would generate a reset token and send an email
        // This is just a placeholder - implement actual email sending logic
        $resetToken = bin2hex(random_bytes(32));
        
        // Store the token in the database (you'd need to add this field)
        // $this->userModel->updateUser($user['id'], ['reset_token' => $resetToken]);
        
        // Send email with reset link
        // sendResetEmail($user['email'], $resetToken);
        
        Session::flash("success", "Password reset instructions sent to your email");
        return $this->jsonSuccess(null, 'Reset instructions sent');
    }
}