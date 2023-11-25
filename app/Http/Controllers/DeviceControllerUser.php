<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Parameters;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DeviceControllerUser extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()['id'];

        $devices = DB::table('devices')
            ->where('user_id','=',"$user_id")
            ->paginate(10);

        return view('basic_user.devices.index')->with(['devices' => $devices]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user_id = Auth::user()['id'];

        DB::table('devices')->insert([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'alias' => $request->input('alias'),
            'user_id' => $user_id,
        ]);

        return redirect(route('user.devices'));
    }

    /**
     * Display the specified resource.
     */
    public function show($encrypted_id)
    {
        try{
            $user_id = Auth::user()['id'];

            $device_id = Crypt::decrypt($encrypted_id);
            error_log("$device_id");
            $device = DB::table('devices')->where('id','=', $device_id)->get();


            $parameters = DB::table('parameters')
                ->join('types', 'parameters.type_id', '=', 'types.id')
                ->leftJoin('kpis', 'parameters.kpi_id','=','kpis.id')
                ->where('device_id','=', $device_id)
                ->select('parameters.id', 'parameters.result', 'types.id as tid', 'types.name', 'kpis.name as kpi_name')
                ->get()
                ->sortBy('id');

            $kpis = DB::table('kpis')
                ->where('user_id','=',"$user_id")
                ->join('types','kpis.type_id','=','types.id')
                ->select('kpis.id', 'kpis.name','types.id as tid', 'types.name as type_name')
                ->get();

            $types = DB::table('types')->get();

            error_log("$parameters");
            error_log("$kpis");
            error_log("$device");

            $info['device'] = $device;
            $info['parameters'] = $parameters;
            $info['kpis'] = $kpis;
            $info['types'] = $types;

            return view('basic_user.devices.show', compact('info', 'info'));
        }
        catch(Exception $e){
            return redirect(route('user.devices'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        DB::table('devices')->where('id', '=', $request->input('device_id'))->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'alias' => $request->input('alias'),
            'type' => $request->input('type'),
        ]);

        return redirect(route('admin.devices'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('devices')->where('id','=',$id)->delete();
        return redirect(route('user.devices'));
    }
    public function reserve(Request $request)
    {
        //Checks if device was already reserved, by checking the lock
        try{
            $lock = DB::table('devices')->where('id', '=', $request->input('device_id'))->get('system_id');
            if (is_null($lock[0]->system_id)){
                DB::table('devices')->where('id', '=', $request->input('device_id'))->update([
                    'system_id' => $request->input('system_id'),
                ]);
            }} catch(Exception $e){
            return redirect()->back()->witn("error", "There was an error!");
        }

        return redirect()->back()->with("success", "Device was successfully added!");
    }

    public function free(string $id)
    {
        DB::table('devices')->where('id','=', $id)->update(['system_id'=> null]);

        return redirect()->back()->with("success", "Device was successfully removed from the system!");
    }
}
