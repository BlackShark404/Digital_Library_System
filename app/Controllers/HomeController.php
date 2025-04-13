<?php

namespace App\Controllers;

use App\controllers\BaseController;

class HomeController extends BaseController{
    public function index() {
        $this->render('home/index');
    }
}