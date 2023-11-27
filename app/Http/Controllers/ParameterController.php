<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Parameters;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\error;
use App\Traits\CheckResultDevice;
use App\Traits\CheckResult;
use function Laravel\Prompts\select;

class ParameterController extends Controller
{
    use CheckResultDevice;
    use CheckResult;

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required',
            'type' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $device_id = $request->input('device_id');
        $type = $request->input('type');

        $value = DB::table('types')
            ->where('id','=',"$type")
            ->select('value')
            ->get();

        $value = json_decode($value[0]->value, true);

        foreach ($value as $elem_key => $elem){
            $num_of_elem = count($elem);
            if($num_of_elem === 1){
                foreach ($elem as $val){
                    $value["$elem_key"] = $val[0];
                }
            }else if($num_of_elem === 2){
                foreach ($elem as $limits){
                    $from = $limits[0];
                    break;
                }
                $value["$elem_key"] = $from;
            }
        }

        $value = json_encode($value);

        DB::table('parameters')->insert([
            'type_id' => $type,
            'device_id' => $device_id,
            'value' => $value,
        ]);

        $param_id = DB::table('parameters')
            ->where('device_id','=',"$device_id")
            ->select('id')
            ->get();

        $param_id = $param_id[0]->id;

        $this->CheckResultFunc($param_id,null);

        return redirect()->back()->with('success','Parameter successfully created');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'param_id' => 'required',
            'kpi_id' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $param_id = $request->input('param_id');
        $kpi_id = $request->input('kpi_id');

        $this->CheckResultFunc($param_id, $kpi_id);

        return redirect()->back()->with('success','Parameter successfully edited');
    }

    public function destroy(string $id)
    {
        try {
            $device_id = DB::table('parameters')
                ->where('id','=',"$id")
                ->select('device_id')
                ->get();

            $device_id = $device_id[0]->device_id;

            DB::table('parameters')
                ->where('id','=',$id)
                ->delete();
        }catch (Exception $e){
            return redirect()->back()->with('error','Parameter could not be destroyed. Already does not exist or invalid ID');
        }

        $this->CheckResultDeviceFunc($device_id);

        return redirect()->back()->with('success','Parameter successfully deleted');
    }
}
