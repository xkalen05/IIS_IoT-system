<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait CheckEmail
{
    public function CheckEmailFunc($email):bool
    {
        error_log("$email");

        if (preg_match('/^\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b$/', $email)) {
            return true;
        } else {
            error_log("bad mail");
            return false;
        }
    }
}
