<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Traits\CheckResult;

class KPIController extends Controller
{
    use CheckResult;

    public function index()
    {
        $kpis = DB::table('kpis')
            ->join('types','types.id','=','kpis.type_id')
            ->join('users', 'kpis.user_id','=','users.id')
            ->select('kpis.*', 'types.name as type_name', 'users.email as user_email')->get();
        error_log("$kpis");
        $types = DB::table('types')->get();

        return view('admin.kpis.index', compact('types', 'types'))->with(['kpis' => $kpis]);

    }

    public function create(Request $request)
    {
        $type_id = $request->input('type');

        $value = DB::table('types')
            ->where('id','=',"$type_id")
            ->select('value')
            ->get();


        $value = json_decode($value[0]->value, true);
        foreach ($value as $val_key => $val){
            $val_elem_num = count($val);
            if($val_elem_num === 2){
                $keys = [];
                foreach ($val as $key => $limits){
                    $from = $limits[0];
                    $to = $limits[1];
                    array_push($keys,"$key");
                }
                $value["$val_key"]["$keys[0]"] = $from;
                $value["$val_key"]["$keys[1]"] = $to;
            }else if($val_elem_num === 1){
                foreach ($val as $key => $limits){
                    $value["$val_key"]["$key"] = $limits[0];
                }
            }
        }
        $value = json_encode($value);

        DB::table('kpis')->insert([
            'type_id' => $request->input('type'),
            'user_id' => Auth::user()['id'],
            'name' => $request->input('name'),
            'value' => $value,
        ]);

        return redirect()->back();
    }

    public function destroy(string $id){

        DB::table('kpis')->where('id','=',$id)->delete();

        return redirect()->back();
    }

    public function edit(Request $request){


        $data = $request->except('_token');
        $id = $data['id'];

        $kpi = DB::table('kpis')->where('id','=',"$id")->select('value', 'type_id')->get();
        $type_id = $kpi[0]->type_id;
        $type = DB::table('types')->where('id','=',"$type_id")->select('value')->get();
        $type = json_decode($type[0]->value,true);



        $value = json_decode($kpi[0]->value,true);

        foreach ($data as $var_key => $var){
            // Checks if income value is number
            if(!is_numeric($var)){
                error_log("Value $var is not a number");
                return redirect()->back();
            }

            // Check if value is in boundaries
            foreach ($type as $type_value){
                foreach ($type_value as $type_val_key => $type_val){
                    if($type_val_key === $var_key && ($type_val[0] > $var || $type_val[1] < $var)){
                        error_log("Value $var is not in boundaries");
                        return redirect()->back();
                    }
                }
            }

            //error_log("$var_key $var");
            foreach ($value as $val_key => $val){
                foreach ($val as $elem_key => $elem){
                    if($var_key === $elem_key){
                        //error_log("$var_key === $elem_key");
                        $value["$val_key"]["$elem_key"] = intval($var);
                        $new_val = $value["$val_key"]["$elem_key"];
                        //error_log("$new_val");
                    }
                }
            }
        }

        $value = json_encode($value);
        error_log("$value");
        DB::table('kpis')->where('id','=',"$id")->update([
            'value' => $value,
        ]);
        error_log("db updated");

        $param_table = DB::table('kpis')
            ->where('kpis.id','=',"$id")
            ->join('parameters','parameters.kpi_id','=','kpis.id')
            ->select('kpis.id as kpi_id', 'parameters.id as param_id')
            ->get();

        foreach ($param_table as $res){
            $this->CheckResultFunc($res->param_id, $res->kpi_id);
        }

        return redirect()->back();
    }
}
