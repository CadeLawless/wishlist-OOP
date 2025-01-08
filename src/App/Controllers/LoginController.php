<?php

namespace App\Controllers;

use Core\Controller;
use Helpers\FormValidation;
use Helpers\FormField;
use App\Models\User;

class LoginController extends Controller
{
    public function index(): void
    {
        $formValidation = new FormValidation();
        $username = new FormField(
            formValidation: $formValidation,
            name: "username",
            type: "text",
            required: true,
            label: "Username or Email"
        );
        $password = new FormField(
            formValidation: $formValidation,
            name: "password",
            type: "password",
            required: true,
            label: "Password"
        );
        $rememberMe = new FormField(
            formValidation: $formValidation,
            name: "remember_me",
            type: "checkbox",
            required: false,
            label:"Remember Me"
        );

        if(isset($_POST["login_submit"])){
            $formValidation->validateFormFields();

            $user = new User();
            if($user->validateUser(username: $username, password: $password)){
                
            }
        }

        $this->view('login', ['title' => 'Wish List | Login', 'formValidation' => $formValidation]);
    }
}

?>