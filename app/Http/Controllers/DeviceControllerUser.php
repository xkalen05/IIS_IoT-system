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
     * Display the specified resource.
     */
    public function show($encrypted_id)
    {
        try{
            $user_id = Auth::user()['id'];

            $device_id = Crypt::decrypt($encrypted_id);
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
}
