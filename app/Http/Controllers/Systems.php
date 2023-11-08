<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class Systems extends Controller
{
    function systems(){
        if(Auth::check()){
            return view('systems');
        }
        return redirect(route('login'))->with("error","Not logged in");
    }
}
