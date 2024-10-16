<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use App\Traits\CheckResultDevice;

trait CheckResult
{
    use CheckResultDevice;
    public function CheckResultFunc($param_id, $kpi_id){
        if($kpi_id === null){
            $kpi_id = DB::table('parameters')
                ->where('parameters.id','=',"$param_id")
                ->select('kpi_id')
                ->get();


            if($kpi_id[0]->kpi_id === null){
                DB::table('parameters')
                    ->where('id','=',"$param_id")
                    ->update([
                        'result' => 0
                    ]);

                $device_id = DB::table('parameters')
                    ->where('id','=',"$param_id")
                    ->select('device_id')
                    ->get();

                $device_id = $device_id[0]->device_id;
                $this->CheckResultDeviceFunc($device_id);
                return;
            }

            $kpi_id = $kpi_id[0]->kpi_id;
        }

        /* Check for change in parameters result */
        error_log("$kpi_id");
        $kpi = DB::table('kpis')
            ->where('id','=',"$kpi_id")
            ->select('value')
            ->get();
        $kpi_value = json_decode($kpi[0]->value,true);

        $param_value = DB::table('parameters')
            ->where('id','=',"$param_id")
            ->select('value')
            ->get();
        $param_value = json_decode($param_value[0]->value,true);

        $result = 1;
        $end = 0;
        $from = 0;
        $to = 0;
        foreach ($kpi_value as $kpi_elem){
            $num_of_kpi_elem = count($kpi_elem);
            if($num_of_kpi_elem === 1){
                foreach ($kpi_elem as $kpi_val){
                    foreach ($param_value as $param_val){
                        if($param_val !== $kpi_val){
                            $result = 0;
                            $end = 1;
                            break;
                        }
                    }
                }
            }elseif ($num_of_kpi_elem === 2){
                foreach ($kpi_elem as $kpi_val){
                    $from = $kpi_val;
                    break;
                }
                foreach ($kpi_elem as $kpi_val){
                    $to = $kpi_val;
                }
                error_log("$from $to");
                if($param_value === null){
                    $result = 0;
                    $end = 1;
                }else {
                    foreach ($param_value as $param_val) {
                        if ($param_val < $from || $param_val > $to) {
                            error_log("FAULT: $param_val < $from || $param_val > $to");
                            $result = 0;
                            $end = 1;
                            break;
                        }
                    }
                }
            }

            if($end === 1){
                break;
            }
        }

        error_log("RESULT $result");

        DB::table('parameters')->where('id','=',"$param_id")->update([
            'kpi_id' => $kpi_id,
            'result' => $result
        ]);

        $device_id = DB::table('parameters')
            ->where('id','=',"$param_id")
            ->select('device_id')
            ->get();

        $device_id = $device_id[0]->device_id;

        $this->CheckResultDeviceFunc($device_id);
    }
}
