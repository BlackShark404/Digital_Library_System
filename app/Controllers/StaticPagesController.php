<?php

namespace App\Controllers;

class StaticPagesController extends HomeController{
    public function contactUs() {
        $this->render('static/contact-us');
    }

    public function privacy() {
        $this->render('static/privacy');
    }
}