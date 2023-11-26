<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\CheckResult;

class KPIController extends Controller
{
    use CheckResult;

    public function index()
    {
        $types = DB::table('types')
            ->get();

        if(Auth::user()['role'] === 'admin'){
            $kpis = DB::table('kpis')
                ->join('types','types.id','=','kpis.type_id')
                ->join('users', 'kpis.user_id','=','users.id')
                ->select('kpis.*', 'types.name as type_name', 'users.email as user_email')
                ->get();

            return view('admin.kpis.index', compact('types', 'types'))->with(['kpis' => $kpis]);
        }else {
            $user_id = Auth::user()['id'];
            $kpis = DB::table('kpis')
                ->join('types', 'types.id', '=', 'kpis.type_id')
                ->where('kpis.user_id', '=', "$user_id")
                ->select('kpis.*', 'types.name as type_name')
                ->get();

            return view('basic_user.kpis.index', compact('types', 'types'))->with(['kpis' => $kpis]);
        }
    }

    public function create(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|max:255|min:3',
            'type' => 'required'
        ]);

        if(!$validation){
            return redirect()->back()->with('error','Validation error');
        }

        $user_id = Auth::user()['id'];
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
            'user_id' => $user_id,
            'name' => $request->input('name'),
            'value' => $value,
        ]);

        return redirect()->back()->with('success','KPI successfully created');
    }

    public function destroy(string $id){

        DB::table('kpis')->where('id','=',$id)->delete();

        return redirect()->back()->with('success','KPI successfully deleted');
    }

    public function edit(Request $request){
        $data = $request->except('_token');
        $id = $data['id'];

        $kpi = DB::table('kpis')
            ->where('id','=',"$id")
            ->select('value', 'type_id')
            ->get();
        $type_id = $kpi[0]->type_id;

        $type = DB::table('types')
            ->where('id','=',"$type_id")
            ->select('value')
            ->get();

        $type = json_decode($type[0]->value,true);
        $value = json_decode($kpi[0]->value,true);

        foreach ($data as $var_key => $var){
            // Checks if income value is number
            if(!is_numeric($var)){
                return redirect()->back()->with('error',"Value is not a number(\"$var_key\":\"$var\")");
            }

            // Check if value is in boundaries
            foreach ($type as $type_value){
                foreach ($type_value as $type_val_key => $type_val){
                    if($type_val_key === $var_key && ($type_val[0] > $var || $type_val[1] < $var)){
                        error_log("Value $var is not in boundaries");
                        return redirect()->back()->with('error',"Value \"$var_key\":\"$var\" is not in boundaries(<$type_val[0];$type_val[1]>)");
                    }
                }
            }

            foreach ($value as $val_key => $val){
                foreach ($val as $elem_key => $elem){
                    if($var_key === $elem_key){
                        $value["$val_key"]["$elem_key"] = intval($var);
                    }
                }
            }
        }

        $value = json_encode($value);

        DB::table('kpis')->where('id','=',"$id")->update([
            'value' => $value,
        ]);

        $param_table = DB::table('kpis')
            ->where('kpis.id','=',"$id")
            ->join('parameters','parameters.kpi_id','=','kpis.id')
            ->select('kpis.id as kpi_id', 'parameters.id as param_id')
            ->get();

        foreach ($param_table as $res){
            $this->CheckResultFunc($res->param_id, $res->kpi_id);
        }

        return redirect()->back()->with('success','KPI range successfully changed');
    }
}
