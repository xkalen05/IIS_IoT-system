<?php

namespace App\Http\Controllers;

use App\Models\Device;
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
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\NoReturn;
use Exception;
use App\Traits\CheckResultSystem;

class SystemControllerAdmin extends Controller
{
    use CheckResultSystem;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id = Auth::user()['id'];

        $system = System::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'system_admin_id' => $user_id
        ]);

        $system->users()->attach($user_id);

        return redirect(route('admin.systems'))->with('success', 'System was successfully created');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function share(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'system_id' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $system = System::find($request->input('system_id'));

        $system->users()->attach($request->input('user_id'));

        return redirect(route('admin.systems'))->with('success', 'System was successfully shared with user');
    }


    /**
     * Display the specified resource.
     */
    public function show(System $system)
    {
        $devices = $system->devices;
        $user_id = Auth::user()['id'];

        $devices_free = DB::table('devices')
            ->where('system_id', '=', '')
            ->orWhereNull('system_id')
            ->where('user_id','=', $user_id)
            ->get();

        $name = $system->name;
        return view('admin.systems.show', compact('system', 'name', 'devices', 'devices_free'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'system_id' => 'required',
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $user_id = Auth::user()['id'];

        DB::table('systems')
            ->where('id', '=', $request->input('system_id'))
            ->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);

        $system = System::find($request->input('system_id'));
        $system->users()->sync([$user_id]);

        CheckResultSystemFunc($request->input('system_id'));

        return redirect(route('admin.systems'))->with('success', 'Changes were successfully saved');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::table('systems')
                ->where('id', '=', $id)
                ->delete();
        }catch (Exception $e){
            return redirect()->back()->with('error','System could not be destroyed. Already does not exist or invalid ID');
        }

        CheckResultSystemFunc($id);

        return redirect(route('admin.systems'))->with('success', 'System was successfully deleted');
    }

}
