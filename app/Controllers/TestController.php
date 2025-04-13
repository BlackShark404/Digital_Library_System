<?php

namespace App\Controllers;

class TestController extends BaseController{
    public function test2()
    {
        $this->redirect("/register");
    }
}