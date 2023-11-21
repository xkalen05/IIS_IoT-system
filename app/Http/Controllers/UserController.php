<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $users = DB::table('users')->paginate(10);

        return view('admin.users.index')->with(['users' => $users]);
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
    public function edit(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
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

    public function editPassword(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        DB::table('users')->where('id', '=', $request->input('user_id'))->update([
                'password' => Hash::make($request->input('password'))
            ]);

        return redirect(route('admin.users'));
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
