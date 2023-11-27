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
use Illuminate\Support\Facades\Validator;

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
            ->paginate(1000);

        return view('admin.devices.index')->with(['devices' => $devices]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:3',
            'description' => 'max:255',
            'alias' => 'max:255',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id = Auth::user()['id'];

        DB::table('devices')->insert([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'alias' => $request->input('alias'),
            'user_id' => $user_id,
        ]);

        return redirect()->back()->with('success','Device was successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show($encrypted_id)
    {
        try{
            $device_id = Crypt::decrypt($encrypted_id);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:3',
            'description' => 'max:255',
            'alias' => 'max:255',
            'device_id' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('devices')
            ->where('id', '=', $request->input('device_id'))
            ->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'alias' => $request->input('alias')
            ]);

        return redirect()->back()->with('success','Device successfully edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            DB::table('devices')
                ->where('id','=',$id)
                ->delete();
        }catch (Exception $e){
            return redirect()->back()->with('error','Device could not be deleted, already does not exist or invalid ID.');
        }

        return redirect()->back()->with('success','Device was successfully deleted');
    }

    public function reserve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required',
            'system_id' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Checks if device was already reserved, by checking the lock
        try{
            $lock = DB::table('devices')
                ->where('id', '=', $request->input('device_id'))
                ->get('system_id');
            if (is_null($lock[0]->system_id)){
                DB::table('devices')
                    ->where('id', '=', $request->input('device_id'))
                    ->update([
                        'system_id' => $request->input('system_id'),
                ]);
            }
        } catch(Exception $e){
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
