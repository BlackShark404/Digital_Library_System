<?php

namespace App\Controllers;

use Core\Session;

class TestController extends BaseController {
    public function showTestView() {
        $this->render('test/sample');
    }

    public function viewData() {
        $this->render("/test/view-data");
    }

    public function getData() {
        if (!$this->isAjax()) {
            $this->jsonError('Invalid request type', 400);
            return;
        }

        if (!$this->isPost()) {
            $this->jsonError('Invalid request method', 405);
            return;
        }

        $data = $this->getJsonInput();

        if (empty($data['name']) || empty($data['age'])) {
            $this->jsonError('Name and age are required');
            return;
        }

        Session::set('name', $data['name']);
        Session::set('age', $data['age']);
        
        
        // Return a success response
        return $this->jsonSuccess("Information submitted successfully!");
          
    }

    public function showTestModal() {
        $this->render('test/test-modal');
    }

    public function testModal() {
        $data = $this->getJsonInput();

        $username = $data['username'];
        $email = $data['email'];

        if (!empty($username) || !empty($email)) {
            return $this->jsonSuccess([
                "username" => $username,
                "email" => $email,
            ], "Successfully received");
        };

    }
}