<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\System;
use App\Models\SystemSharingRequest;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\NoReturn;

class SystemControllerAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $users = User::all();
        $userSystems = System::paginate(1000);
        $sharingRequests = SystemSharingRequest::all();
        $hasSharingRequests = SystemSharingRequest::exists();

        return view('admin.systems.index')->with(['systems' => $userSystems, 'users' => $users,
            'sharingRequests' => $sharingRequests, 'hasSharingRequests' => $hasSharingRequests]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:4',
            'description' => 'required|string|max:100',
            // Add other validation rules if needed
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Redirect back with errors and old input
            return redirect(route('admin.systems'))->with('error', 'An Error occured when creating a system')->
                withErrors($validator)->withInput();
        }

        // Validation passed, create the system
        $user_id = Auth::id();
        $system = System::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'system_admin_id' => $user_id
        ]);

        $system->users()->attach($user_id);

        return redirect(route('admin.systems'))->with('success', 'System was sucessfully created');
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


        return redirect(route('admin.systems'))->with('success', 'System was sucessfully shared with user');

    }


    /**
     * Display the specified resource.
     */
    public function show(System $system)
    {
        $devices = $system->devices;
        $devices_free = DB::table('devices')->where('system_id', '=', '')->orWhereNull('system_id')->get();
        $name = $system->name;
        return view('admin.systems.show', compact('system', 'name', 'devices', 'devices_free'));
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

        return redirect(route('admin.systems'))->with('success', 'Changes were succesfully saved');
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
        return redirect(route('admin.systems'))->with('success', 'System was succesfully deleted');
    }

}
