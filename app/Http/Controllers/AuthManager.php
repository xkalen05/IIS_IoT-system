<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Traits\CheckUserCredentials;

class AuthManager extends Controller
{
    use CheckUserCredentials;
    function login(){
        return view('login');
    }

    function registration(){
        return view('registration');
    }

    function loginPost(Request $request){
         $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('systems');
        }
        error_log("here");
        return redirect(route('login'))->with("error", "Login details are not valid");
    }

    function registrationPost(Request $request){
        $request->validate([
            'email' => 'required|unique:user',
            'password' => 'required'
        ]);

        // Check email validity
        if(!$this->checkEmailForm($request->email)){
            return redirect(route('registration'))->with("error","Invalid email form");
        }

        //Check password validity
        if(!$this->checkPasswordForm($request->password)){
            return redirect(route('registration'))->with("error","Invalid password");
        }

        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);

        if(!$user){
            return redirect(route('registration'))->with("error","registration failed");
        }
        return redirect(route('login'))->with("success","User \"" . $data['email'] . "\" successfully registrated");
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
