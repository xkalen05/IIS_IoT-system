<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Parameters;
use App\Models\System;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = DB::table('devices')
            ->join('users','devices.user_id','=','users.id')
            ->select('devices.*', 'users.email as user_email')
            ->paginate(10);

        return view('admin.devices.index')->with(['devices' => $devices]);

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

        return redirect(route('admin.devices'));
    }

    /**
     * Display the specified resource.
     */
    public function show($encrypted_id)
    {
        try{
            $device_id = Crypt::decrypt($encrypted_id);
            error_log("$device_id");
            $device = DB::table('devices')
                ->join('users','devices.user_id','=','users.id')
                ->where('devices.id','=', $device_id)
                ->select('devices.id', 'devices.name', 'devices.user_id')
                ->get();

            $parameters = DB::table('parameters')
                ->join('types', 'parameters.type_id', '=', 'types.id')
                ->leftJoin('kpis', 'parameters.kpi_id','=','kpis.id')
                ->where('device_id','=', $device_id)
                ->select('parameters.id', 'parameters.result', 'types.id as tid', 'types.name', 'kpis.name as kpi_name', 'kpis.user_id as kpi_user_id')
                ->get()
                ->sortBy('id');

            $kpis = DB::table('kpis')
                ->join('types','kpis.type_id','=','types.id')
                ->select('kpis.id', 'kpis.name', 'kpis.user_id','types.id as tid', 'types.name as type_name')
                ->get();

            $types = DB::table('types')->get();

            error_log("para: $parameters");
            error_log("kpis: $kpis");
            error_log("devi: $device");

            $info['device'] = $device;
            $info['parameters'] = $parameters;
            $info['kpis'] = $kpis;
            $info['types'] = $types;

            return view('admin.devices.show', compact('info', 'info'));
        }
        catch(Exception $e){
            return redirect(route('admin.devices'));
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

        return redirect()->back();
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
        DB::table('devices')->where('id','=',$id)->delete();
        return redirect()->back();
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
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function free(string $id)
    {
        DB::table('devices')->where('id','=', $id)->update(['system_id'=> null]);

        return redirect()->back();
    }
}
/** TODO:
 * - admin is default owner
 * */
