<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Parameters;
use App\Models\System;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
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
        $devices = DB::table('devices')->paginate(10);

        return view('admin.devices.index')->with(['devices' => $devices]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $device = Device::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'alias' => $request->input('alias'),
            'type' => $request->input('type'),
        ]);

        if ($request->has('parameters')) {
            foreach ($request->parameters as $parameter) {
                Parameters::create([
                    'name' => $parameter['name'],
                    'value' => $parameter['value'],
                    'device_id' => $device->id
                ]);
            }
        }

        return redirect()->back();
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
    public function show($encrypted_id)
    {
        try{
            $device_id = Crypt::decrypt($encrypted_id);
            $device = DB::table('devices')->where('id','=', $device_id);

            $parameters = DB::table('parameters')->where('device_id', $device_id)->get();

            return view('admin.devices.show', compact('device', 'parameters'));
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
