<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait CheckRange
{
    public function CheckRangeFunc($variables, $param_id){
        error_log("here");

        $type_value = DB::table('parameters')
            ->join('types','types.id','=','parameters.type_id')
            ->where('parameters.id','=',"$param_id")
            ->select('types.value as value')
            ->get();


        $type_value = json_decode($type_value[0]->value,true);

        $error_message = "";

        foreach ($variables as $var_key => $var){
            foreach ($type_value as $type_elem_key => $type_elem){
                if($var_key !== $type_elem_key){
                    continue;
                }
                $type_elem_num = count($type_elem);
                $from = 0;
                $to = 0;
                if($type_elem_num === 2){
                    foreach ($type_elem as $type_val){
                        $from = $type_val[0];
                        break;
                    }
                    foreach ($type_elem as $type_val){
                        $to = $type_val[1];
                    }
                }else if($type_elem_num === 1){
                    foreach ($type_elem as $type_val){
                        $from = $type_val[0];
                        $to = $type_val[1];
                    }
                }
                error_log("$from < $var < $to");
                if($var < $from){
                    $variables["$var_key"] = $from;
                    $error_message = $error_message . "$var_key is out of range, set to lowest value in range(range: <$from,$to>)\n";
                    break;
                }elseif($var > $to){
                    $variables["$var_key"] = $to;
                    $error_message = $error_message . "$var_key is out of range, set to highest value in range(range: <$from;$to>)\n";
                    break;
                }
            }
        }
        return [$variables,$error_message];
    }
}
