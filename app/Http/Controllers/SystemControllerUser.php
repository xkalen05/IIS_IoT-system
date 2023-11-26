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
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Traits\CheckResultSystem;

class SystemControllerUser extends Controller
{
    use CheckResultSystem;

    /**
     * Display a listing of the resource.
     */
    public function indexMySystems(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $users = User::all();

        $userId = Auth::user()['id'];
        $userSystems = System::where('system_admin_id', $userId)->paginate(1000);
        $sharingRequests = SystemSharingRequest::where('system_owner_id', $userId)->paginate(1000);
        $hasSharingRequests = SystemSharingRequest::where('system_owner_id', $userId)->exists();

        return view('basic_user.systems.index-my-systems')->with(['systems' => $userSystems, 'users' => $users,
            'sharingRequests' => $sharingRequests, 'hasSharingRequests' => $hasSharingRequests]);
    }

    public function indexSharedWithMe(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();

        // Retrieve the systems that belong to the user
        $userSystems = $user->systems()->where('system_admin_id', '!=', $user->id)->paginate(1000);

        return view('basic_user.systems.index-shared-with-me')->with(['systems' => $userSystems]);
    }

    public function indexOtherSystems(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $users = User::all();

        // Retrieve the systems that do not belong to the user
        $otherSystems = System::whereDoesntHave('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->paginate(1000);

        return view('basic_user.systems.index-other-systems')->with(['otherSystems' => $otherSystems, 'users' => $users]);
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

        return redirect(route('user.systems'))->with('success', 'System was sucessfully created');
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

        return redirect(route('user.systems'))->with('success', 'System was sucessfully shared');

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

        return redirect(route('user.systems.others'));
    }


    /**
     * Display the specified resource.
     */
    public function show(System $system)
    {
        $devices = $system->devices;
        $user_id = Auth::id();

        $devices_free = DB::table('devices')
            ->where('system_id', '=', '')
            ->orWhereNull('system_id')
            ->where('user_id','=', $user_id)
            ->get();

        $name = $system->name;
        return view('basic_user.systems.show', compact('system', 'name', 'devices', 'devices_free'));
    }

    public function showShared(System $system)
    {
        $devices = $system->devices;

        $name = $system->name;
        return view('basic_user.systems.showShared', compact('system', 'name', 'devices'));
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

        DB::table('systems')->where('id', '=', $request->input('system_id'))->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        $system = System::find($request->input('system_id'));
        $system->users()->sync([$user_id]);

        $this->CheckResultSystemFunc($request->input('system_id'));

        return redirect(route('user.systems'))->with('success', 'Changes were successfully saved');
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

        return redirect(route('admin.systems'))->with('success', 'System was successfully deleted');
    }
}
