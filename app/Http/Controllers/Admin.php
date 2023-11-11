<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Admin extends Controller
{
    function editUser(Request $request){
        if(isset($request->user)) {
            $user_info = DB::table('user')->select('email','admin')->
                         where('email','=', $request->user)->get();
            $user_info = json_decode($user_info, true);
            $user_info = $user_info[0];
            return view('edit-user')->with("user_info", $user_info);
        }
        return redirect('/admin'); // TODO: error msg
    }

    function editUserPost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'admin' => 'required',
        ]);
        error_log($request->email);
        $user = DB::table('user')->where('email','=',$request->email)
            ->update(['password' => Hash::make($request->password), 'admin' => $request->admin]);
        return redirect('/admin');
    }

    function admin(){
        $users = DB::table('user')->select('email')->get();
        $users = json_decode($users,true);
        if(Auth::check()){
            $user = Auth::user();
            if($user['admin'] === 1) {
                return view('admin')->with("users",$users);
            }
            return back()->with("error","You are not admin");
        }
        return redirect(route('/login'))->with("error","Not logged in");
    }
}
