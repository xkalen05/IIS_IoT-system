<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Parameters;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\error;
use App\Traits\CheckResult;

class ParameterControllerUser extends Controller
{
    use CheckResult;
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'device_id' => 'required',
            'type' => 'required'
        ]);
        $device_id = $request->input('device_id');
        $type = $request->input('type');
        error_log("$type");

        DB::table('parameters')->insert([
            'type_id' => $type,
            'device_id' => $device_id,
        ]);

        return redirect()->back();
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $param_id = $request->input('param_id');
        $kpi_id = $request->input('kpi_id');

        $this->CheckResultFunc($param_id, $kpi_id);

        return redirect()->back();
    }

    public function destroy(string $id)
    {
        error_log("param id $id");
        DB::table('parameters')->where('id','=',$id)->delete();
        return redirect()->back();
    }
}
