<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();   // TODO prasarna
        $users = User::all();
        // Retrieve the systems that belong to the user
        $systems = $user->systems()->paginate(10);

        return view('admin.systems.index')->with(['systems' => $systems, 'users' => $users]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user_id = Auth::id();  // TODO prasarna

        $system = System::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'system_admin_id' => $user_id
        ]);

        $system->users()->attach($user_id);

        return redirect(route('admin.systems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function share(Request $request)
    {
        //dd($request);
        // TODO pridavaji se i systemy ktere uy jsou pridane
        $system = System::find($request->input('system_id'));

        $system->users()->attach($request->input('user_id'));


        return redirect(route('admin.systems'));

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
    public function edit(Request $request)
    {
        $user_id = Auth::id();  // TODO prasarna

        DB::table('systems')->where('id', '=', $request->input('system_id'))->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        $system = System::find($request->input('system_id'));
        $system->users()->sync([$user_id]);

        return redirect(route('admin.systems'));
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
    public function destroy(string $id)
    {
        DB::table('systems')->where('id', '=', $id)->delete();
        return redirect(route('admin.systems'));
    }
}
