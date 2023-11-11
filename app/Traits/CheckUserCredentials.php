<?php

namespace App\Traits;

trait CheckUserCredentials{
    protected function checkEmailForm(string $email){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            return 1;
        }
        return 0;
    }

    protected function checkPasswordForm(string $pwd){
        $minimal_password_len = 3;
        if(strlen($pwd) < $minimal_password_len){
            return 0;
        }
        return 1;
    }
}
