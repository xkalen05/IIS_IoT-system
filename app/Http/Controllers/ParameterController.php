<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Parameters;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParameterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try{
            decrypt($request->input('device_id'));
        }
        catch (Exception $e){
            return redirect(route('admin.devices'));
            return redirect()->back();
        }

        Parameters::create([
            'name' => $request->input('name'),
            'kpi' => $request->input('kpi'),
            'value' => $request->input('value'),
            'device_id' => decrypt($request->input('device_id')),
        ]);

        return redirect()->back();
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        DB::table('parameters')->where('id', '=', $request->input('param_id'))->update([
            'name' => $request->input('name'),
            'kpi' => $request->input('kpi'),
            'value' => $request->input('value'),
        ]);

        return redirect()->back();
    }
}
