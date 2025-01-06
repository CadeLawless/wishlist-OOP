<?php

ini_set("display_errors", 1);

session_start();

namespace Middleware;

use App\Models\User;

class AuthMiddleware
{
    public function handle(): void
    {
        $user = new User();
        
        $logged_in = $user->checkIfLoggedIn();

        if (!$logged_in) {
            // Redirect to login page if not authenticated
            header('Location: /login');
            exit;
        }else{
            $user->setInformation();
        }
    }
}

?>