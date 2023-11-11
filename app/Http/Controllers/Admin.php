<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Traits\CheckUserCredentials;

class Admin extends Controller
{
    use CheckUserCredentials;

    public function editUser(Request $request){
        if(Auth::check()) {
            $user = Auth::user();
            if($user['admin'] === 1) {
                if (isset($request->user)) {
                    $user_info = DB::table('user')->select('email', 'admin')->
                    where('email', '=', $request->user)->get();
                    $user_info = json_decode($user_info, true);
                    $user_info = $user_info[0];
                    return view('edit-user')->with("user_info", $user_info);
                }
                back()->with("error","Unexpected error: unknown user");
            }
            return back()->with("error","You are not admin");
        }
        return redirect(route('admin'))->with("error","You are not logged in");
    }

    public function editUserPost(Request $request)
    {
        // Auth user
        if(Auth::check()) {
            $user = Auth::user();
            if($user['admin'] === 1) {
                // Validate input
                $request->validate([
                    'email' => 'required',
                    'password' => 'required',
                    'admin' => 'required',
                ]);

                // Check minimal password length
                if (!$this->checkPasswordForm($request->password)) {
                    return redirect('/admin/' . $request->email)->with("error", "Invalid password");
                }

                // Update DB
                $user = DB::table('user')->where('email', '=', $request->email)
                    ->update(['password' => Hash::make($request->password), 'admin' => $request->admin]);
                return redirect(route('admin'))->with("success","User info successfully changed");
            }
            return redirect(route('systems'))->with("error","You are not admin");
        }
        return redirect(route('login'))->with("error","You are not logged in");
    }

    function admin(){
        // Checks if logged in
        if(Auth::check()){
            $user = Auth::user();
            // Checks if user is admin
            if($user['admin'] === 1) {
                $users = DB::table('user')->select('email')->get();
                $users = json_decode($users,true);
                return view('admin')->with("users",$users);
            }
            return back()->with("error","You are not admin");
        }
        return redirect(route('login'))->with("error","You are not logged in logged in");
    }
}
