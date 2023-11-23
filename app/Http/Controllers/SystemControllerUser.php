<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\SystemSharingRequest;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SystemControllerUser extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $users = User::all();

        // If the user is not an admin, retrieve the systems that belong to the user
        $userSystems = $user->systems()->paginate(10);
        // Retrieve the systems that do not belong to the user
        $otherSystems = System::whereDoesntHave('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->paginate(10);

        return view('basic_user.systems.index')->with(['systems' => $userSystems, 'otherSystems' => $otherSystems, 'users' => $users]);
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

        return redirect(route('user.systems'));
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


        return redirect(route('user.systems'));

    }

    public function shareRequest(string $systemID)
    {
        $userId = auth()->id();

        // Fetch the system admin ID based on the system ID
        $system = System::find($systemID);
        $systemAdminId = $system->system_admin_id;

        // Create a new sharing request record
        SystemSharingRequest::create([
            'system_id' => $systemID,
            'request_user_id' => $userId,
            'system_owner_id' => $systemAdminId
        ]);

        return redirect(route('user.systems'));
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

        return redirect(route('user.systems'));
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
        return redirect(route('user.systems'));
    }
}
