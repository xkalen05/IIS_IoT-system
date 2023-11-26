<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use App\Traits\CheckResultSystem;

trait CheckResultDevice
{
    use CheckResultSystem;

    public function CheckResultDeviceFunc($device_id){
        /* Check for dependencies, change of result in device and system */
        if($device_id === null){
            return;
        }
        $end = 0;
        $result = 1;

        // Find all parameters in device
        $params_in_device = DB::table('devices')
            ->join('parameters','parameters.device_id','=',"devices.id")
            ->where('devices.id','=',"$device_id")
            ->select('parameters.result')
            ->get();

        // Go trough all parameters in device, check for all results
        foreach ($params_in_device as $device_param){
            foreach ($device_param as $param_result){
                if($param_result === 0){
                    $result = 0;
                    $end = 1;
                    break;
                }
                error_log("RESULT PARAM: $param_result");
            }
            if($end === 1){
                $end = 0;
                break;
            }
        }

        // Update result in device
        DB::table('devices')
            ->where('id','=',"$device_id")
            ->update([
                'result' => $result,
            ]);

        $system = DB::table('devices')
            ->where('devices.id','=',"$device_id")
            ->select('system_id')
            ->get();

        $this->CheckResultSystemFunc($system[0]->system_id);
    }
}
