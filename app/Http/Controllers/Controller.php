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
use App\Oximeter;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $BASELINE = 2;
    public $SKIN = 3;
    public $VALSA = 4;
    public $DEEPBREADING = 5;
    public $STANDING = 6;
    public $HANDGRIP = 7;

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
        
       // $allocation_id = 139;
        $gsrs = GSR::where('allocation_id', $allocation_id)
        ->where('step_id', $step)
        ->get();           
        if($gsrs->first()){
            $n = 0; $gsr_value = 0;
            $foot_index = 0; $gsr_value_foot = 0;
            foreach($gsrs as $item){            
                $value  = json_decode($item["raw_data"], true);
                foreach($value as $vv){ 
                    
                    $gsr_value += $vv;
                    $n++;
                    // $hand = $vv["hand"];            
                    // $foot = $vv["foot"];
                    // foreach($hand as $v){                   
                    // }
                    // foreach($foot as $v){                      
                    //     $gsr_value_foot += $v;
                    //     $foot_index++;
                    // }                
    
                }            
            }
    
            if($n > 0 ){
                return [$gsr_value/$n , $gsr_value/$n];
            }  
        }

        return [0, 0];        
    }


    function getOximeterRR($allocation_id, $step){
        $oximeters = Oximeter::where('allocation_id', $allocation_id)
        ->where('step_id', $step)
        ->get(); 

        //return json_encode($oximeters);                
        $RR_VALUE = [];
        $total_rr = 0; $n = 0;
        foreach($oximeters as $item){            
            
            $value  = json_decode($item["raw_data"], true);
            foreach($value as $v){
                foreach($v["RR"] as $vv){                                     
                    $RR_VALUE[] = $vv;
                    $total_rr += $vv;
                    $n++;                
                }
            }            
        }
        

        $avg = 0;
        if($n > 0){
            $avg = $total_rr/$n;
        }
        return [$RR_VALUE, $avg];        
    }

    function getSDNN($allocation_id, $step){   
        $data = $this->getOximeterRR($allocation_id, $step);
        $RR  = $data[0];
        $avg = $data[1];
        $total_tmp = 0;
        foreach($RR as $val){
            $total_tmp += ($val - $avg) * ($val - $avg);    
        }        

        if(count($RR) != 0){
            return  sqrt ($total_tmp /  count($RR) ) ;
        }
        return 0;        
    }
     
    
    function getRMSSD($allocation_id, $step){

       $data = $this->getOximeterRR($allocation_id, $step);
        $RR  = $data[0];
        $avg = $data[1];
        $total_tmp = 0;
        $tmp = 0;
        foreach($RR as $val){
            if($tmp != 0){
                $total_tmp += ($val - $tmp) * ($val - $tmp);    
            }
            $tmp = $val;       
            
        }   
        
        if((count($RR) - 1) != 0){
            return  sqrt ($total_tmp /  (count($RR) - 1) ) ;
        }        
        return 0;

    }

}
