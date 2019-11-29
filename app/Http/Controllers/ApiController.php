<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Session;
use App\UserType;
use Response;
use DB;
use App\State;
use App\City;
use App\Users;
use App\Oximeter;
use App\Blood;
use App\GSR;
use App\Allocation;
use App\Message;
use App\Company;
use App\AllocationVisitForm;
use DateTime;
use Config;


class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // login api from device
    public function login(Request $request){       
        $email = $request->input('email');        
        $password = $request->input('password');
        $user = Users::where('email_address', $email)->where('user_password', $password)->get();        
        
        if($user->first()){

            $allocation = Allocation::where('administer_num',$user->first()->id)->where('is_allocated', '1');              
            if($allocation->first()){

                $id = "00000000".$user->first()->id;
                $patient_id = "00000000".$allocation->first()->user_num;

                $key1 = substr($id, -8);
                $key2 = substr($patient_id, -8);
                $a = array('results'=>200, 'apikey'=>"DS".$key1.$key2.date('Ymd'));
                
                return Response::json($a);
            }else{
                $a = array('results'=>400);
                return Response::json($a);         
            }     
        }
        $a = array('results'=>300);
        return Response::json($a);                
    }

    public function getAvgSysDia( $allocation_id , $step){
        
    }
    

    public function getLevel($allocation_id, $step){
        
        $blood = Blood::where('allocation_id', $allocation_id)
        ->where('step_id', $step)
        ->get();           
        $n = 0; $sys = 0; $dia = 0; $bpm = 0;
        $max_tmp = 0; $min_tmp = 0; $max = 0; $min = 0;
        foreach($blood as $item){            
            $value  = json_decode($item["raw_data"], true);
            foreach($value as $v){                              
                $sys = $sys + $v["systolic"];
                $dia = $dia + $v["diastolic"];
                $bpm = $bpm + $v["bpm"];
                
                if($n == 0){
                    $min_tmp = $v["bpm"];
                }

                if($max_tmp < $v["bpm"]){
                    $max_tmp = $v["bpm"];
                }
                if($min_tmp > $v["bpm"]){
                    $min_tmp = $v["bpm"];
                }

                $n++;
            }
        }

        $avg_systolic = 0; $avg_diastolic = 0; $avg_bpm = 0;
        if($n != 0){
            $avg_systolic = $sys/$n;
            $avg_diastolic = $dia/$n;
            $avg_bpm = $bpm/$n;
        }

        $overview_score = 0;
        if($avg_systolic > 120 && $avg_diastolic < 129 && $avg_diastolic < 80){
            $overview_score = $overview_score + 1;
        }else if( ($avg_systolic > 130 && $avg_diastolic < 139) || ($avg_diastolic > 80 && $avg_diastolic < 89) ){
            $overview_score = $overview_score + 3;
        }else if( ($avg_systolic > 140 && $avg_diastolic < 179) || ($avg_diastolic > 90 && $avg_diastolic < 119) ){
            $overview_score = $overview_score + 4;
        }else if($avg_systolic >= 180 || $avg_diastolic >= 120){
            $overview_score = $overview_score + 5;
        }

        return [$overview_score, $avg_systolic, $avg_diastolic, $avg_bpm, $min_tmp, $max_tmp];
    }




    public function test(Request $request){

        $allocation_id = "139";
         //Overall Blood Pressure         
        $value1 =  $this->getLevel($allocation_id, 3);
        $value2 =  $this->getLevel($allocation_id, 6);
        $SPRS = abs($value1[Config::get('constants.options.avg_systolic')] - $value2[Config::get('constants.options.avg_systolic')]);
        $DPRS = abs($value1[Config::get('constants.options.avg_diastolic')] - $value2[Config::get('constants.options.avg_diastolic')]);

        $score = $value1[Config::get('constants.options.score')] + $value2[ Config::get('constants.options.score') ];
        if($SPRS >= 10 && $SPRS < 20){
            $score = $score + 2;
        }else if($SPRS >= 20 && $SPRS < 30){
            $score = $score + 3;
        }else if($SPRS >= 30){
            $score = $score + 4;
        }
        if($DPRS >= 5 && $DPRS < 10){
            $score = $score + 2;
        }else if($DPRS >= 10 && $DPRS < 20){
            $score = $score + 3;
        }else if($DPRS >= 20){
            $score = $score + 4;
        }

        $value3 =  $this->getLevel($allocation_id, 4);
        $score = $score + $value3[Config::get('constants.options.score')];
        $SPRV = ($value1[Config::get('constants.options.avg_systolic')] - $value3[ Config::get('constants.options.avg_systolic') ]);
        if( $SPRV > -20 && $SPRV <= -10){
            $score = $score + 2;
        }else if($SPRV > -10 && $SPRV <= -5){
            $score = $score + 3;
        }else if($SPRV > -5){
            $score = $score + 4;
        }
        
        if($value3[Config::get('constants.options.min_heart_rate')] != 0){
            $VRC4 = $value3[Config::get('constants.options.max_heart_rate')] / $value3[Config::get('constants.options.min_heart_rate')];
        }else{
            $VRC4 = 0;
        }                            
        if($VRC4 > 1.25){
            $score = $score + 1;
        }
        if( $value2[Config::get('constants.options.min_heart_rate')] != 0){
            $VRC6 = $value2[Config::get('constants.options.max_heart_rate')] / $value2[Config::get('constants.options.min_heart_rate')];
        }else{
            $VRC6 = 0;
        }        
        if($VRC6 > 1.13){
            $score = $score + 1;
        }
        echo $score;
        $a = array('results'=> 200 );
        //return Response::json($a);  
    }   
    
   // receive data from device PHD ( attached 3 sensors)
   public function send(Request $request){
        
    $device_id =  $request->input('device_id');
    $phd_name =  $request->input('phd_name');
    $apikey =  $request->input('apikey');                

    $administer_id = (int)substr($apikey, 2, 8);
    $patient_id = (int)substr($apikey, 10, 8);
    $allocation = Allocation::where('administer_num', $administer_id)
    ->where('user_num', $patient_id)
    ->where('is_allocated', 1)
    ->get();
    
    if($allocation->first()){

        $allocation_id = $allocation->first()->auto_num;
        $step_id = $allocation->first()->step;
        $tracking = $allocation->first()->tracking;

        // SPO2 Device
        $oximeter = $request->input('oximeter');        
        $device1 = json_decode($oximeter, TRUE);
        if(count($device1) > 0){
            
            if(strpos($tracking, "1") !== false){ // disable/endalble the device                                
            }else{
                $oximeter = new Oximeter();
                $oximeter->device_serial_num = $device_id;
                $oximeter->o2_percent = 0;
                $oximeter->bpm_value = 0;
                $oximeter->user_num = $patient_id;
                $oximeter->administer_num = $administer_id;
                $oximeter->allocation_id = $allocation_id;            
                $oximeter->raw_data = json_encode($device1);                
                $oximeter->step_id = $step_id;
                $oximeter->save();  
            }
                                                 
        }
        
        //Blood Sensor
        $blood  = $request->input('blood');
        $device2 = json_decode($blood, TRUE);
            
        if(count($device2) > 0 ){
            
            if(strpos($tracking, "2") !== false){
                
            }else{
                $blood = new Blood();
                $blood->device_serial_num = $device_id;
                $blood->systolic_value = 0;
                $blood->diastolic_value= 0;
                $blood->bpm_value = 0;
                
                $blood->user_num = $patient_id;
                $blood->administer_num = $administer_id;
                $blood->allocation_id = $allocation_id; 
                $blood->raw_data = json_encode($device2);    
                $blood->step_id = $step_id;

                $blood->save();  
            }
                     
        }
        
        // GSR Data 
        $gsr_data  = $request->input('gsr');
        $device3 = json_decode($gsr_data, TRUE);
        if(count($device3) > 0 ){
            if(strpos($tracking, "3") !== false){
                
            }else{
                $gsr = new GSR();
                $gsr->device_serial_num = $device_id;
                $gsr->conductance = 0;
                $gsr->resistance = 0;
                $gsr->user_num = $patient_id;
                $gsr->administer_num = $administer_id;
                $gsr->allocation_id = $allocation_id; 
                $gsr->raw_data = json_encode($device3);  
                $gsr->step_id = $step_id;

                $gsr->save();
            }
        }

        $a = array('results'=> 200 );
        return Response::json($a);    
    }else{
        $a = array('results'=> 300 , 'data'=>'Not Allocated');
        return Response::json($a); 
    }                                        
} 


    public function send1(Request $request){

        $device_id =  $request->input('device_id');
        $phd_name =  $request->input('phd_name');
        $apikey =  $request->input('apikey');          
        $oximeter = $request->input('oximeter');
        $device1 = json_decode($oximeter, TRUE);
 
         foreach($device1 as $item) {
             $val1 = $item['SPO2bpm'];
             $val2 = $item['OxygenSat'];
             
             if($device_id != null){            
                 $oximeter = new Oximeter();
                 $oximeter->device_serial_num = $device_id;
                 $oximeter->o2_percent = $val2;
                 $oximeter->bpm_value = $val1;
                 $oximeter->user_num = $apikey;
                 $oximeter->save();    
           }
         }
         
         $blood  = $request->input('blood');
         $device2 = json_decode($blood, TRUE);
            
         foreach($device2 as $item) {
             $val1 = $item['systolic'];
             $val2 = $item['diastolic'];
             $val3 = $item['bpm'];
             
             if($device_id != null){            
                 $blood = new Blood();
                 $blood->device_serial_num = $device_id;
                 $blood->systolic_value = $val1;
                 $blood->diastolic_value= $val2;
                 $blood->bpm_value = $val3;
                 $blood->user_num = $apikey;
                 $blood->save();                     
           }            
         }
 
                 
        $gsr_data  = $request->input('gsr');
        $gsr = new GSR();
        $gsr->device_serial_num = $device_id;
        $gsr->conductance = $gsr_data;
        $gsr->user_num = $apikey;
        $gsr->save();

        $a = array('results'=> 200 );
        return Response::json($a);        
     } 
    


    public function allocatePatient(Request $request){
          
        $patient_id = $request->input('patient_id');
        $device_id = $request->input('device_id');        
        $id = $request->input('id');
        $company_id = $request->input('company_id');        
        $allocation_name = $request->input('allocation_name');
        $visit_form_id = $request->input('visit_form_id');
    
        if($patient_id != null && $device_id != null && $id != null){            
            $allocation = new Allocation();               
            $allocation->serial_num = $device_id;
            $allocation->administer_num = $id;
            $allocation->user_num = $patient_id;
            $allocation->company_id = $company_id;
            $allocation->is_allocated = "1";
            $allocation->allocation_name = $allocation_name;
            $allocation->visit_form_id = $visit_form_id;
            $allocation->save();
            $allocation_id = Allocation::where('administer_num',$id)->where('is_allocated', '1')->get()->first()->auto_num;


            //$aaa = array('results'=>200, 'id'=>$allocation_id);
            $aaa = array('results'=>200, 'id'=>$allocation_id);  // For T
            return Response::json($aaa);            
        }

        $a = array('results'=>300, 'data'=>$device_id);
        return Response::json($a);
    }
    
    // complete allocation by status 0 : complete, 1: allocated, 2: abort
    public function completeAllocation(Request $request){        
        $id = $request->input('allocation_id');
        $status = $request->input('status');        
            DB::table('tbl_allocation')
            ->where('auto_num', $id)
            ->update(['is_allocated' => $status]);           

        $aaa = array('results'=>200, 'data'=>$id);
        return Response::json($aaa);          
    }

    // remove all records by allocation id and step id ( work with reset button)
    public function resetAllocation(Request $request){


        $allocation_id = $request->input('allocation_id');
        $step = $request->input('step_id');

        // delete from oxymeter sensor
        $res1 = Oximeter::where('allocation_id',$allocation_id)
        ->where('step_id',$step)
        ->delete();
        // delete from blood sensor
        $res2 = Blood::where('allocation_id',$allocation_id)
        ->where('step_id',$step)
        ->delete();
        // delete from blood gsr sensor
        $res3 = GSR::where('allocation_id',$allocation_id)
        ->where('step_id',$step)
        ->delete();

        if($res1 && $res2 && $res3){
            $aaa = array('results'=>200 ,'data'=>'deleted');
            return Response::json($aaa); 
        }else{
            $aaa = array('results'=>200, 'data' => 'no record');
            return Response::json($aaa); 
        }
    }

    // update the status of New Test 
    public function updateStep(Request $request){

        $patient_id = $request->input('patient_id');
        $device_id = $request->input('device_id');        
        $id = $request->input('id');
        $company_id = $request->input('company_id');        
        $allocation_name = $request->input('allocation_name');
        $step = $request->input('stepValue');
        $visit_form_id = $request->input('visit_form_id');
        $diabet_risk_id = $request->input('diabet_risk_id');

        if($step == "1"){    
      
            if($patient_id != null && $device_id != null && $id != null){

                $oxymeter = $request->input('oxymeter') == true? "1" :"";
                $blood = $request->input('blood') == true? "2" :"";
                $gsr = $request->input('gsr') == true? "3" :"";

                $allocation = new Allocation();               
                $allocation->serial_num = $device_id;
                $allocation->administer_num = $id;
                $allocation->user_num = $patient_id;
                $allocation->company_id = $company_id;
                $allocation->is_allocated = "1";
                $allocation->allocation_name = $allocation_name;
                $allocation->step = $step;
                $allocation->tracking = $oxymeter.$blood.$gsr;
                $allocation->visit_form_id = $visit_form_id;
                $allocation->diabet_risk_id = $diabet_risk_id;
                $allocation->save();

                $allocation_id = Allocation::where('administer_num',$id)->where('is_allocated', '1')->get()->first()->auto_num;                
                $aaa = array('results'=>200, 'id'=>$allocation_id);
                return Response::json($aaa);            
            }
        }else{            
           
            $allocation_id = $request->input('allocation_id');
            DB::table('tbl_allocation')
            ->where('auto_num', $allocation_id)
            ->update(['step' => $step]);            
            $a = array('results'=>200, 'id'=>$allocation_id);
            return Response::json($a);
        }
        $a = array('results'=>300, 'data'=>$device_id);
        return Response::json($a);        
        
         

    }

    public function deleteUserType(Request $request){
        if($request != null){
            $id = $request->input('id');
            DB::delete('delete from tbl_user_type where auto_num = ?',[$id]);     
        }
        $a = array('results'=>200);
        return Response::json($a);
    }

    public function deleteComapny(Request $request){
        if($request != null){
            $id = $request->input('id');

            $com = Company::where('auto_num', $id)->get();
            if($com->first()){
                $email = $com->first()->office_email;
                DB::table('tbl_company')->where('office_email', '=', $email)->where('history', '=', '0')->delete();    
            }
            DB::delete('delete from tbl_company where auto_num = ?',[$id]);     
        }
        $a = array('results'=>200);
        return Response::json($a);
    }

    public function deleteUser(Request $request){
        if($request != null){
            $id = $request->input('id');
            DB::delete('delete from tbl_user where id = ?',[$id]);     
        }
        $a = array('results'=>200);
        return Response::json($a);
    }
    public function deletePatient(Request $request){

        if($request != null){
            $id = $request->input('id');
            $tmp = json_encode($id);
            $ids = json_decode($tmp, true);
            $idArray = [];
            foreach($ids as $i){
                $idArray[] = $i;
            }

            DB::table('tbl_user')->whereIn('id', $idArray)->delete(); 
            //DB::delete("delete from tbl_user where auto_num IN (' ".$idArray." ')");                 
        }
        $a = array('results'=>200, 'data' => $idArray );
        return Response::json($a);
    }
    


    public function deleteShip(Request $request){
        if($request != null){
            $id = $request->input('id');
            DB::delete('delete from tbl_user_shipping where auto_num = ?',[$id]);     
        }
        $a = array('results'=>200);
        return Response::json($a);
    }

    public function deleteBill(Request $request){
        if($request != null){
            $id = $request->input('id');
            DB::delete('delete from tbl_user_billing where auto_num = ?',[$id]);     
        }
        $a = array('results'=>200);
        return Response::json($a);
    }
    public function deleteDevice(Request $request){
        if($request != null){
            $id = $request->input('id');
            DB::delete('delete from tbl_device where auto_num = ?',[$id]);     
        }
        $a = array('results'=>200);
        return Response::json($a);
    }



    public function  getState(Request $request){
        if($request != null){
            $id = $request->input('id');
            $state = State::where('country_id', $id)->get();
            $a = array('results'=>200, 'state'=>$state);
            return Response::json($a);
        }
        $a = array('results'=>300);
        return Response::json($a);
    }

    public function  getCity(Request $request){
        if($request != null){
            $id = $request->input('id');
            $state = City::where('state_id', $id)->orderBy("city_name")->get();
            $a = array('results'=>200, 'city'=>$state);
            return Response::json($a);
        }
        $a = array('results'=>300);
        return Response::json($a);
    }

    // get sensor data by sensor_id (used for real time graph)
    public function getData(Request $request){

        if($request  != null){
            $sensor_id = $request->input('sensor_id');
            $allocation_id = $request->input('allocation_id');
            $id = $request->input('id');

            $data = array();  
            $spo2 = array();
            $oxygen = array();    
            $systolic = array();
            $diastolic = array();
            $blood_bpm = array();      

            if($sensor_id == '0'){ // in the case of Oxygen Sensor                
                $data = Oximeter::where('allocation_id', $allocation_id)->latest('auto_num')->get();
                if($data->first() ){ //&& $id != $data->first()->auto_num    // for checking last record was readed already or not
                    $tmp = json_decode($data->first()->raw_data, true);                  
                    foreach($tmp as $item){
                        $spo2[] = $item["SPO2bpm"];
                        $oxygen[] = $item["OxygenSat"];
                    }               
                    $data = $data->first();
                }else{
                    $data = [];
                }
                $a = array('results'=>200, 'data'=>$data, 'spo2'=>$spo2, 'oxygen'=>$oxygen);
                return Response::json($a);
                
                
            }else if($sensor_id == '1'){ // in the case of Blood pressue sensor
                $data = Blood::where('allocation_id', $allocation_id)->latest('auto_num')->get();
                if($data->first() ){ //&& $id != $data->first()->auto_num 
                    $tmp = json_decode($data->first()->raw_data, true);                  
                    foreach($tmp as $item){
                        $systolic[] = $item["systolic"];
                        $diastolic[] = $item["diastolic"];
                        $blood_bpm[] = $item['bpm'];
                    }               
                    $data = $data->first();
                }else{
                    $data = [];
                }
                $a = array('results'=>200, 'data'=>$data, 'systolic'=>$systolic, 'diastolic'=>$diastolic, 'blood_bpm'=>$blood_bpm);
                return Response::json($a);  

            }else{ // in the case of GSR sensor

            }
                    
        }
        $a = array('results'=>300);
        return Response::json($a);
    }


    public function getAllSensorData(Request $request){

        if($request  != null){   
            $allocation_id = $request->input('allocation_id');
            $id_oxygen = $request->input('id_oxygen');
            $id_blood = $request->input('id_blood');
            $id_gsr = $request->input('id_gsr');
                        
            $spo2 = array();
            $oxygen = array();    
            $systolic = array();
            $diastolic = array();
            $blood_bpm = array();   
            $gsr_values = array();   

         
            // get Pluse Oxymeter data
            $oxymeter = Oximeter::where('allocation_id', $allocation_id)->latest('auto_num')->get();
            if($oxymeter->first() && $id_oxygen != $oxymeter->first()->auto_num ){ //&& $id_oxygen != $data->first()->auto_num    // for checking last record was readed already or not
                $tmp = json_decode($oxymeter->first()->raw_data, true);                  
                foreach($tmp as $item){
                    $spo2[] = $item["SPO2bpm"];
                    $oxygen[] = $item["OxygenSat"];
                }               
                $id_oxygen = $oxymeter->first()->auto_num;
            }
        
            // get  Blood Pressure sensor data
            $blood = Blood::where('allocation_id', $allocation_id)->latest('auto_num')->get();
            if($blood->first() && $id_blood != $blood->first()->auto_num  ){ //&& $id != $data->first()->auto_num 
                $tmp = json_decode($blood->first()->raw_data, true);                  
                foreach($tmp as $item){
                    $systolic[] = $item["systolic"];
                    $diastolic[] = $item["diastolic"];
                    $blood_bpm[] = $item['bpm'];
                }               
                $id_blood = $blood->first()->auto_num;
            }           
             // get  GSR Sensor data
             $gsr = GSR::where('allocation_id', $allocation_id)->latest('auto_num')->get();
             if($gsr->first() && $id_gsr != $gsr->first()->auto_num ){ //&& $id_gsr != $gsr->first()->auto_num 
                 $tmp = json_decode($gsr->first()->raw_data, true);                  
                 foreach($tmp as $item){                     
                     $gsr_values[] = $item;
                 }               
                 $id_gsr = $gsr->first()->auto_num;
             }


             $a = array('results'=>200, 'id_oxygen'=>$id_oxygen,'id_blood'=>$id_blood,'id_gsr'=>$id_gsr,
             'spo2'=>$spo2, 'oxygen'=>$oxygen, 'systolic'=>$systolic, 'diastolic'=>$diastolic, 'blood_bpm'=>$blood_bpm ,'gsr'=>$gsr_values );
             return Response::json($a); 
                    
        }
        $a = array('results'=>300);
        return Response::json($a);
    }
 
    public function getTestInfo(Request $request){

         $start = $request->input('start');
         $end = $request->input('end');
         $id = $request->input('id');
         $company_id = $request->input('company_id');

         $start_tmp = explode("/", $start);
         $end_tmp = explode("/", $end);

         $start = $start_tmp[2]."-".$start_tmp[0]."-".$start_tmp[1];
         $end = $end_tmp[2]."-".$end_tmp[0]."-".$end_tmp[1];
 
         if($id == "-1"){
                
            // get patient
            $usertype = UserType::where('user_type_name',"Patient")->get();
            $patients = Users::where('user_type_id', $usertype->first()->auto_num)->where('company_id', $company_id)->get();
                    
            // get overal data.
            $all  = Allocation::where('company_id', $company_id)->whereBetween('created_at', array($start, $end))->get();            
            $data['total_tests']  = $all->count();
            $data['success_tests'] = Allocation::where('is_allocated','0')->whereBetween('created_at', array($start, $end))->get()->count();
            $data['failed_tests'] = Allocation::where('is_allocated', '2')->whereBetween('created_at', array($start, $end))->get()->count();
            if($all->first()){
                $sdt = new DateTime($all->first()->created_at);
                $edt = new DateTime($all->last()->created_at);
                $data['start_date'] = $sdt->format('Y-m-d');
                $data['end_date'] = $edt->format('Y-m-d');
            }else{
                $data['start_date'] = $start;
                $data['end_date'] = $end;
            }

            // get error data
            $spCount = 0;
            $bCount = 0;
            $gsrCount = 0;            
            foreach($all as $device){
                if(strpos($device->tracking, '1')  !== false){
                    $spCount++;
                }
                if(strpos($device->tracking, '2')  !== false){
                    $bCount++;
                }
                if(strpos($device->tracking, '3')  !== false){
                    $gsrCount++;
                }
            
            }
            $data['oxygen'] = $spCount;
            $data['blood_pressure'] = $bCount;
            $data['gsr'] = $gsrCount;
    
            $data['phase4'] = Allocation::where('is_allocated', '2')->where('step', '>=' , '1')->whereBetween('created_at', array($start, $end))->get()->count();
            $data['phase3'] = Allocation::where('is_allocated', '2')->where('step', '>=' , '1')->where('step', '<' , '4')->whereBetween('created_at', array($start, $end))->get()->count();
            $data['phase2'] = Allocation::where('is_allocated', '2')->where('step', '>=' , '1')->where('step', '<' , '3')->whereBetween('created_at', array($start, $end))->get()->count();
            $data['phase1'] = Allocation::where('is_allocated', '2')->where('step', '>=' , '1')->where('step', '<' , '2')->whereBetween('created_at', array($start, $end))->get()->count();
            $data['test_aborts'] = Allocation::where('is_allocated', '2')->whereBetween('created_at', array($start, $end))->get()->count();

            //$allocation = Allocation::where('company_id', Session::get('company_id'))->get();
            foreach($all as $allo){
                $admin = Users::where('id', $allo->administer_num)->get();
                if($admin->first()){
                    $allo->administer_num = $admin->first()->first_name;
                }
            }

            $a = array('results'=>200, 'data'=>$data, 'allocation'=>$all, 'patients'=>$patients);
            return Response::json($a);
         }else{
            

              // get patient
              $usertype = UserType::where('user_type_name',"Patient")->get();
              $patients = Users::where('user_type_id', $usertype->first()->auto_num)->where('company_id', $company_id)->get();
                        
              // get overal data.
              $all  = Allocation::where('company_id', $company_id)->where('user_num', $id)->whereBetween('created_at', array($start, $end))->get();
              $data['total_tests']  = $all->count();
              $data['success_tests'] = Allocation::where('is_allocated','0')->where('user_num', $id)->whereBetween('created_at', array($start, $end))->get()->count();
              $data['failed_tests'] = Allocation::where('is_allocated', '2')->where('user_num', $id)->whereBetween('created_at', array($start, $end))->get()->count();
              if($all->first()){
                $sdt = new DateTime($all->first()->created_at);
                $edt = new DateTime($all->last()->created_at);
                $data['start_date'] = $sdt->format('Y-m-d');
                $data['end_date'] = $edt->format('Y-m-d');
            }else{
                $data['start_date'] = $start;
                $data['end_date'] = $end;
            }
      
              // get error data
              $spCount = 0;
              $bCount = 0;
              $gsrCount = 0;
              //$disabledDevices = Allocation::all();
              foreach($all as $device){
                  if(strpos($device->tracking, '1')  !== false){
                      $spCount++;
                  }
                  if(strpos($device->tracking, '2')  !== false){
                      $bCount++;
                  }
                  if(strpos($device->tracking, '3')  !== false){
                      $gsrCount++;
                  }              
              }
              
              $data['oxygen'] = $spCount;
              $data['blood_pressure'] = $bCount;
              $data['gsr'] = $gsrCount;
      
              $data['phase4'] = Allocation::where('is_allocated', '2')->where('step', '>=' , '1')->where('user_num', $id)->whereBetween('created_at', array($start, $end))->get()->count();
              $data['phase3'] = Allocation::where('is_allocated', '2')->where('step', '>=' , '1')->where('step', '<' , '4')->where('user_num', $id)->whereBetween('created_at', array($start, $end))->get()->count();
              $data['phase2'] = Allocation::where('is_allocated', '2')->where('step', '>=' , '1')->where('step', '<' , '3')->where('user_num', $id)->whereBetween('created_at', array($start, $end))->get()->count();
              $data['phase1'] = Allocation::where('is_allocated', '2')->where('step', '>=' , '1')->where('step', '<' , '2')->where('user_num', $id)->whereBetween('created_at', array($start, $end))->get()->count();
              $data['test_aborts'] = Allocation::where('is_allocated', '2')->where('user_num', $id)->whereBetween('created_at', array($start, $end))->get()->count();
      
      //        $allocation = Allocation::where('company_id', Session::get('company_id'))->get();    
              foreach($all as $allo){
                  $admin = Users::where('id', $allo->administer_num)->get();
                  if($admin->first()){
                      $allo->administer_num = $admin->first()->first_name;
                  }
              }

              $a = array('results'=>200, 'data'=>$data, 'allocation'=>$all, 'patients'=>$patients);
              return Response::json($a);
         }
                                
    }




    //----------------------------------- Office Message -----------------------------------------------------------------------
    public function addMessage(Request $request){
        
        $title = $request->input('title');
        $body = $request->input('body');
        $active_days = $request->input('active_days');
        $expire_date = $request->input('expire_date');
        $created_date = $request->input('created_date');
        $company_id = $request->input('company_id');
        
        $message = new Message();
        $message->title = $title;
        $message->body= $body;
        $message->active_days = $active_days;
        $message->expire_date = $expire_date;
        $message->created_date = $created_date;
        $message->company_id = $company_id;
        $message->save();
        
        $a = array('results'=>200,'data'=>$created_date);
        return Response::json($a);
    }

    public function editMessage(Request $request){
        
        $title = $request->input('title');
        $body = $request->input('body');
        $active_days = $request->input('active_days');
        $expire_date = $request->input('expire_date');
        $created_date = $request->input('created_date');
        $company_id = $request->input('company_id');
        $id = $request->input('id');
        
        DB::table('tbl_messages')
            ->where('id', $id)
            ->update(['title' => $title,'body' => $body,
            'active_days' => $active_days,'expire_date' => $expire_date,
            'created_date' => $created_date,'company_id' => $company_id ]);

        $a = array('results'=>200,'data'=>$created_date);
        return Response::json($a);
    }

    public function deleteMessage(Request $request){

        $id = $request->input('id');
        $res1 = Message::where('id',$id)->delete();

        if($res1){
            $a = array('results'=>200);
            return Response::json($a);
        }else{
            $a = array('results'=>300);
            return Response::json($a);
        }
        
    }

    public function deleteMessageByChk(Request $request){

        if($request != null){
            $id = $request->input('id');
            $tmp = json_encode($id);
            $ids = json_decode($tmp, true);
            $idArray = [];
            foreach($ids as $i){
                $idArray[] = $i;
            }

            DB::table('tbl_messages')->whereIn('id', $idArray)->delete();             
        }
        $a = array('results'=>200, 'data' => $idArray );
        return Response::json($a);
    }



    public function getMessages(Request $request){
        
        $start = $request->input('start');
        $end = $request->input('end');
        $start_tmp = explode("/", $start);
        $end_tmp = explode("/", $end);
        $start = $start_tmp[2]."-".$start_tmp[0]."-".$start_tmp[1];
        $end = $end_tmp[2]."-".$end_tmp[0]."-".$end_tmp[1];


        $current_date = date("Y-m-d", time());;

        $all  = Message::whereBetween('created_at', array($start, $end))->get();
        $data['total_message']  = $all->count();
        $data['active_message'] = Message::where('expire_date','>' ,$current_date)->whereBetween('created_at', array($start, $end))->get()->count();
        $data['expire_message'] = Message::where('expire_date','<' ,$current_date)->whereBetween('created_at', array($start, $end))->get()->count();
                      
        //$data['success_tests'] = Allocation::where('is_allocated','0')->whereBetween('created_at', array($start, $end))->get()->count();    
        
        $a = array('results'=>200,'data'=>$data, 'messages'=>$all);
        return Response::json($a);
    }
    
    public function getCities(Request $request){
        $cities = City::all();
        $a = array('results'=>200,'cities'=>$cities);
        return Response::json($a);        
    }

    public function getAddcompany(Request $request){    
        
        if($request != null && $request->has('company_name')){            
            $check = Company::where('company_name', $request->input('company_name'))->get();
            if(!$check->first()){
                $user = new Company();
                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');

                $user->company_name = $request->input('company_name');
                $user->physical_address1 = $request->input('physical_address1');             
                $user->physical_address2 = $request->input('physical_address2');             

                $user->physical_country_id = $request->input('physical_country_id'); 
                $user->physical_city = $request->input('physical_city'); 
                $user->physical_state_id = $request->input('physical_state_id'); 
                $user->physical_zip = $request->input('physical_zip');

                $user->mailing_address1 = $request->input('mailing_address1');             
                $user->mailing_address2 = $request->input('mailing_address2');             

                $user->mailing_country_id = $request->input('mailing_country_id'); 
                $user->mailing_city = $request->input('mailing_city'); 
                $user->mailing_state_id = $request->input('mailing_state_id'); 
                $user->mailing_zip = $request->input('mailing_zip');

                $user->office_phone = $request->input('office_phone');
                $user->office_fax = $request->input('office_fax');
                $user->office_website = $request->input('office_website');
                $user->office_email = $request->input('office_email');                                          
                $user->original_id = 0;
                $user->history = 1;
                $user->save();                

                $user1 = new Company();        
                $user1->first_name = $request->input('first_name');
                $user1->last_name = $request->input('last_name');
                $user1->company_name = $request->input('company_name');
                $user1->physical_address1 = $request->input('physical_address1');             
                $user1->physical_address2 = $request->input('physical_address2');             

                $user1->physical_country_id = $request->input('physical_country_id'); 
                $user1->physical_city = $request->input('physical_city'); 
                $user1->physical_state_id = $request->input('physical_state_id'); 
                $user1->physical_zip = $request->input('physical_zip');

                $user1->mailing_address1 = $request->input('mailing_address1');             
                $user1->mailing_address2 = $request->input('mailing_address2');             

                $user1->mailing_country_id = $request->input('mailing_country_id'); 
                $user1->mailing_city = $request->input('mailing_city'); 
                $user1->mailing_state_id = $request->input('mailing_state_id'); 
                $user1->mailing_zip = $request->input('mailing_zip');

                $user1->office_phone = $request->input('office_phone');
                $user1->office_fax = $request->input('office_fax');
                $user1->office_website = $request->input('office_website');
                $user1->office_email = $request->input('office_email');                                          
                $user1->original_id = $user->id;
                $user1->history = 0;
                $user1->save();

                $a = array('results'=>200, 'messages'=>"Success" , 'id'=>$user->id );
                return Response::json($a);
            }
                               
        }
        
        $a = array('results'=>400, 'messages'=>"No Data" );
        return Response::json($a);
        
    }


    // Visit Form part
    public function addVisitForm(Request $request){
        try{
            $data = $request->all();        
            $response = AllocationVisitForm::create($data);
            $a = array('results'=>200, 'messages'=>'ok' , 'id' => $response->id );
            return Response::json($a);
        }catch(Exception $e){
            $a = array('results'=>400, 'messages'=>'failed' );
            return Response::json($a);
        }
                        

        // $data = $request->all();
        // 
    }

    public function editVisitForm(Request $request){
        try{
            

            $id = $request->input('visit_form_id');

            DB::table('tbl_allocation_visit_form')
            ->where('id', $id)
            ->update([
            'daily_activity' => $request->input('daily_activity') , 'symptoms' => $request->input('symptoms'),
            'disease' => $request->input('disease') , 'treatment' => $request->input('treatment') ]);

            $a = array('results'=>200, 'messages'=>'ok' );
            return Response::json($a);
        }catch(Exception $e){
            $a = array('results'=>400, 'messages'=>'failed' );
            return Response::json($a);
        }
    }

    public function updateWeight(Request $request){
        try{
            
            $patient_id = $request->input('patient_id');
            $weight = $request->input('weight');

            DB::table('tbl_user')
            ->where('id', $patient_id)
            ->update([
            'weight' => $weight ]);

            $a = array('results'=>200, 'messages'=>'ok' );
            return Response::json($a);
        }catch(Exception $e){
            $a = array('results'=>400, 'messages'=>'failed' );
            return Response::json($a);
        }
    }

}
