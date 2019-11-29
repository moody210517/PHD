<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

use Response;
use DB;
use App\Users;
use App\UserType;
use App\Company;
use App\Ship;
use App\Bill;
use App\Country;
use App\State;
use App\City;
use App\Device;
use App\Allocation;
use App\GSR;

use Session;
use DateTime;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     
    function getBMI($weight, $height){
        $bmi = round(($weight * 703) / ($height * $height), 2) ;
        if($bmi <= 18.5){
            $weight_status = "Underweight";
            $color = "text-warning";
        }else if($bmi > 18.5 && $bmi <= 24.9){
            $weight_status = "Normal or Healthy Weight";
            $color = "text-success";
        }else if($bmi > 24.9 && $bmi < 29.9){
            $weight_status = "Overweight";
            $color = "text-warning";
        }else if($bmi > 30){
            $weight_status = "Obese";
            $color = "text-danger";
        }
        // bmi score        
        $bmi_score = 0;
        if($bmi >= 25 && $bmi <= 30){
            $bmi_score =  1;
        }else if($bmi > 30){
            $bmi_score =  3;
        }
        return [$bmi, $weight_status, $color , $bmi_score] ; // val, weight status, color, score
    }

    function getGSR($allocation_id, $step){
        
        $allocation_id = 139;
        $gsrs = GSR::where('allocation_id', $allocation_id)
        ->where('step_id', $step)
        ->get();           
        $n = 0; $gsr_value = 0;
        foreach($gsrs as $item){            
            $value  = json_decode($item["raw_data"], true);
            foreach($value as $vv){     
                $hand = $vv["hand"];            
                $foot = $vv["foot"];
                foreach($hand as $v){                      
                    $gsr_value += $v;
                    $n++;
                }
            }            
        }
        if($n > 0){
            return $gsr_value/$n;
        }
        return 0;
    }


    function getSDNN($RR = []){

        $index = 0;
        $total = 0;
        foreach($RR as $val){
            $total += $val;
            $index++;
        }

        if($index > 0){
            $avg = $total/$index;
        }else{
            $avg = 0;
        }
        

        
        foreach($RR as $val){
            $total_tmp = ($val - $avg) * ($val - $avg);    
        }
        return 0;
    }

    function getRMSSD(){
        return 0;
    }

}
