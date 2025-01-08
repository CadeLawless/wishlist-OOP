<?php

namespace App\Models;

use Core\Model;
use Helpers\FormField;

class User extends Model
{
    protected string $table = 'wishlist_users';
    protected string $username, $fullname, $name, $email;
    protected bool $admin, $email_verified, $dark_theme;

    public function checkIfLoggedIn(): bool
    {
        // Check if the user is authenticated
        $logged_in = $_SESSION["wishlist_logged_in"] ?? false;
        if(!$logged_in){
            if(isset($_COOKIE["wishlist_session_id"])){
                $session = $_COOKIE["wishlist_session_id"];
                $query = "SELECT username, session_expiration FROM $this->table WHERE session = ?";
                $findUser = $this->select(query: $query, values: [$session]);
                if(count($findUser) > 0){
                    foreach($findUser as $row){
                        $session_expiration = $row["session_expiration"];
                        if(date("Y-m-d H:i:s") < $session_expiration){
                            $username = $row["username"];
                            $_SESSION["username"] = $username;
                            $logged_in = true;
                            $_SESSION["wishlist_logged_in"] = true;
                        }
                    }
                }
            }
        }
        
        return $logged_in;
    }

    public function setInformation(): void
    {
        // get username
        $username = $_SESSION["username"] ?? "";

        // find name based off of username
        $findUserInfo = $this->select("SELECT name, role, email, unverified_email, dark FROM wishlist_users WHERE username = ?", [$username]);
        if(count($findUserInfo) > 0){
            foreach($findUserInfo as $row){
                $this->name = htmlspecialchars($row["name"]);
                $_SESSION["name"] = $this->name;
                $this->admin = $row["role"] == "Admin" ? true : false;
                $this->fullname = $row["name"];
                $this->email = $row["email"];
                $this->email_verified = $row["unverified_email"] == "" ? true : false;
                $this->dark_theme = $row["dark"] == "Yes" ? true : false;
            }
        }
    }

    public function validateUser(FormField $username, FormField $password): bool
    {
        return true;
    }
}

?>