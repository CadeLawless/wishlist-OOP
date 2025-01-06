<?php

namespace App\Controllers;

use Core\Controller;

class UserController extends Controller
{
    public function list(): void
    {
        $this->view('home', ['title' => 'Welcome to Our Website']);
    }
}

?>