<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Traits\CheckEmail;

class UserController extends Controller
{
    use CheckEmail;

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $currentUser = Auth::id();
        $users = DB::table('users')->where('id', '!=', $currentUser)->paginate(1000);

        return view('admin.users.index')->with(['users' => $users]);
    }

    public function indexProfile(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();

        return view('profile.index')->with(['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'surname' => 'required|min:1|max:255',
            'email' => 'required|min:1|max:255|email',
            'role' => 'required',
            'password' => 'required|min:8|max:255',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        if(!$this->CheckEmailFunc($request->input('email'))){
            return redirect()->back()->with('error','email is in wrong format')->withInput();
        }

        User::create([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect(route('admin.users'))->with('success', 'User ' . $request->input('name') . ' ' .
            $request->input('surname') .' succesfully created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editUserByAdmin(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'surname' => 'required|min:1|max:255',
            'email' => 'required|min:1|max:255|email|unique:users',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        if(!$this->CheckEmailFunc($request->input('email'))){
            return redirect()->back()->with('error','email is in wrong format')->withInput();
        }

        DB::table('users')->where('id', '=', $request->input('user_id'))->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ]);

        return redirect(route('admin.users'))->with('success', 'Changes were succesfully saved');

    }

    public function editUserByUser(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'surname' => 'required|min:1|max:255',
            'email' => 'required|min:1|max:255|email',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        if(!$this->CheckEmailFunc($request->input('email'))){
            return redirect()->back()->with('error','email is in wrong format')->withInput();
        }

        DB::table('users')->where('id', '=', $request->input('user_id'))->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
        ]);

        return redirect(route('profile.index'))->with('success', 'Changes were succesfully saved');

    }

    public function editPasswordByAdmin(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|max:255',
            'user_id' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        DB::table('users')
            ->where('id', '=', $request->input('user_id'))
            ->update([
                'password' => Hash::make($request->input('password'))
            ]);

        return redirect(route('admin.users'))->with('success', 'Password for user ' . $request->input('name') . ' ' .
            $request->input('surname') .' was succesfully changed.');
    }

    public function editPasswordByUser(Request $request)
    {
        // TODO zmena hesla pro aktualne prihlaseneho uzivatele nefunguje
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|max:255',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $newPassword = $request->input('password');

        Auth::user()->update([
            'password' => Hash::make($newPassword)
        ]);

        return redirect(route('profile.index'))->with('success', 'Password was succefully changed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $systems = DB::table('systems')
                ->where('system_admin_id','=',"$id")
                ->select('id')
                ->get();

            foreach ($systems as $system){
                $sid = $system->id;
                DB::table('systems')
                    ->where('id','=',"$sid")
                    ->delete();
            }

            DB::table('users')
                ->where('id', '=', $id)
                ->delete();
        }catch (Exception $e){
            return redirect(route('admin.users'))->with('error', 'Could not remove user. Already does not exist or wrong ID');
        }
        return redirect(route('admin.users'))->with('success', 'User was succesfully deleted');
    }


}
