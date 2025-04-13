<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController{
    public function dashboard() {
        $userModel = $this->loadModel('User');
        
        $userModel->createUser([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secure_password',
            'role' => 'user'
        ]);


        $this->render('user/dashboard', [
            'title' => 'User Dashboard',
        ]);
    }
}