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

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $currentUser = Auth::id();
        $users = DB::table('users')->where('id', '!=', $currentUser)->paginate(10);

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
        User::create([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect(route('admin.users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editUserByAdmin(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
//        dd($request);
        DB::table('users')->where('id', '=', $request->input('user_id'))->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ]);

        return redirect(route('admin.users'));

    }

    public function editUserByUser(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        //dd($request);
        DB::table('users')->where('id', '=', $request->input('user_id'))->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
        ]);

        return redirect(route('profile.index'));

    }

    public function editPasswordByAdmin(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        DB::table('users')->where('id', '=', $request->input('user_id'))->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return redirect(route('admin.users'));
    }

    public function editPasswordByUser(Request $request)
    {
        // TODO zmena hesla pro aktualne prihlaseneho uzivatele nefunguje
        dd($request);
        $newPassword = $request->input('password');

        Auth::user()->update([
            'password' => Hash::make($newPassword)
        ]);

        return redirect(route('profile.index'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        DB::table('users')->where('id', '=', $id)->delete();
        return redirect(route('admin.users'));
    }


}
