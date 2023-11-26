<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\CheckResult;

class BrokerController extends Controller
{
    use CheckResult;

    public function index(){
        $parameters = DB::table('parameters')
            ->join('devices','devices.id','=','parameters.device_id')
            ->leftJoin('kpis','kpis.id','=','parameters.kpi_id')
            ->join('users','users.id','=','devices.user_id')
            ->join('types','types.id','=','parameters.type_id')
            ->select('parameters.*', 'kpis.name as kpi_name', 'users.email as email', 'types.name as type_name')
            ->get();

        return view('broker.index')->with(['parameters' => $parameters]);
    }

    public function edit(Request $request){
        $variables = $request->except('_token');
        $param_id = $variables['param_id'];
        unset($variables['param_id']);

        $param_value = DB::table('parameters')
            ->where('id','=',"$param_id")
            ->select('value')
            ->get();

        error_log("$param_value");
        $param_value = json_decode($param_value[0]->value,true);

        foreach ($variables as $var_key => $var){
            error_log("$var_key");
            foreach ($param_value as $param_val_key => $param_val){
                if($param_val_key === $var_key){
                    $param_value["$param_val_key"] = intval($var);
                }
            }
        }

        $param_value = json_encode($param_value);

        error_log("$param_value");

        DB::table('parameters')
            ->where('id','=',"$param_id")
            ->update([
            'value' => $param_value
        ]);

        $this->CheckResultFunc($param_id,null);

        if(Auth::user()['role'] === 'admin'){
            return redirect(route('admin.broker.index'));
        }
        return redirect()->back();
    }
}
