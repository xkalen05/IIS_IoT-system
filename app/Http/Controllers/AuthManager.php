<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthManager extends Controller
{
    function login(){
        return view('login');
    }

    function registration(){
        return view('registration');
    }

    function loginPost(Request $request){
         $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('login','password');
        if(Auth::attempt($credentials)){
            return redirect()->intended(route('systems'));
        }
        error_log("here");
        return redirect(route('login'))->with("error", "Login details are not valid");
    }

    function registrationPost(Request $request){
        $request->validate([
            'login' => 'required|unique:user',
            'password' => 'required'
        ]);

        $data['login'] = $request->login;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);

        if(!$user){
            return redirect(route('registration'))->with("error","registration failed");
        }
        return redirect(route('login'));
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
