<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Parameters;
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

        return redirect(route('admin.devices'));
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
            error_log("$device_id");
            $device = DB::table('devices')->where('id','=', $device_id);

            $parameters = DB::table('parameters')
                ->join('types', 'parameters.type_id', '=', 'types.id')
                ->leftJoin('kpis', 'parameters.kpi_id','=','kpis.id')
                ->where('device_id','=', $device_id)
                ->select('parameters.id', 'types.id as tid', 'types.name', 'kpis.name as kpi_name')
                ->get()
                ->sortBy('id');

            $kpis = DB::table('kpis')
                ->join('types','kpis.type_id','=','types.id')
                ->select('kpis.id', 'kpis.name','types.id as tid', 'types.name as type_name')
                ->get();

            $types = DB::table('types')->get();

            error_log("$parameters");
            error_log("$kpis");

            $info['device_id'] = $device_id;
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

        return redirect(route('admin.devices'));
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
        return redirect(route('admin.devices'));
    }
}
