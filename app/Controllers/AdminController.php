<?php

namespace App\Controllers;

class AdminController extends BaseController {
    protected $adminModel;

    public function adminDashboard() {
        $this->render('admin/dashboard');
    }

    public function userManagement() {
        $this->render('admin/user-management');
    }
}