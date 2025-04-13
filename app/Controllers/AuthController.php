<?php

namespace App\Controllers;

class AuthController extends BaseController{
    protected $userModel;

    public function __construct() 
    {
        $this->userModel = $this->loadModel('UserModel');
    }

    public function showRegisterForm() {
        $this->render('auth/register');
    }

    public function showLoginForm() {
        $this->render('auth/login');
    }

}