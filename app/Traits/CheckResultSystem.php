<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait CheckResultSystem
{
    public function CheckResultSystemFunc($system_id){
        /* Check for dependencies, change of result in device and system */
        if($system_id === null){
            return;
        }

        $devices = DB::table('devices')
            ->where('devices.system_id','=',"$system_id")
            ->select('devices.result as result')
            ->get();

        $result = 1;
        foreach ($devices as $device){
            if($device->result === 0){
                $result = 0;
                break;
            }
        }

        if($devices->isEmpty()){
            $result = 0;
        }

        DB::table('systems')
            ->where('id','=',"$system_id")
            ->update([
               'result' => $result,
            ]);
    }
}
