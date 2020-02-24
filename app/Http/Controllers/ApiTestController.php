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
use App\AllocationVisitForm;
use App\UserDiabet;
use App\Blood;



use Config;
use Session;
use DateTime;
use App\Oximeter;


class ApiTestController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     
    public function checkStep(Request $request){
        
        $allocation_id = $request->input('allocation_id');        
        $allocation = Allocation::where('auto_num', $allocation_id)->get();
        if($allocation->first()){
            if($allocation->first()->token_expired_alert == 1){            
                DB::table('tbl_allocation')
                ->where('auto_num', $allocation_id)
                ->update(['token_expired_alert' => 0]);
                $a = array('results'=>400,'msg'=>"token expired");
                return Response::json($a);
            }

            $step_id = $allocation->first()->step;
            $blood =  getLevelBood($allocation_id, $step_id);
            $GSR = $this->getGSR($allocation_id, $step_id);               
            $spo2 = getRR($allocation_id, $step_id);                      

            if($step_id == "1" || $step_id == "2"){
                if($blood[1] == 0){ // no data
                    $a = array('results'=>200,'msg'=>"no data" , 'step_id'=>$step_id);                                
                }else{                                    
                    $a = array('results'=>300,'msg'=>"exist data" , 'step_id'=>$step_id, 
                    'o2'=>$spo2[1], 'hrv'=>$spo2[2], 'us'=>$GSR[0],
                    'sys'=>$blood[1], 'dia'=>$blood[2], 'pul'=>$spo2[0]);
                }
            }else if($step_id == "3"){

                if($GSR[0] == 0){
                    $a = array('results'=>200,'msg'=>"no data" , 'step_id'=>$step_id);  
                }else{
                    $a = array('results'=>300, 'msg'=>'exist data' , 'step_id'=>$step_id, 'us'=>$GSR[0]);
                }                
            }else if($step_id == "4" || $step_id == "5" || $step_id == "6" || $step_id == "7"){
                if($blood[1] == 0){ // no data
                    $a = array('results'=>200,'msg'=>"no data" , 'step_id'=>$step_id);                                
                }else{                                    
                    $a = array('results'=>300,'msg'=>"exist data" , 'step_id'=>$step_id, 
                    'o2'=>$spo2[1], 'hrv'=>$spo2[2], 'us'=>$GSR[0],
                    'sys'=>$blood[1], 'dia'=>$blood[2], 'pul'=>$spo2[0]);
                }
            }else if($step_id == "8"){
                $a = array('results'=>200,'msg'=>"no data" , 'step_id'=>$step_id); 
            }
            return Response::json($a);                     
        }else{
            $a = array('results'=>300,'msg'=>"no allocation");
            return Response::json($a);
        }        
    }

    public function startStep(Request $request){
        $step_id = $request->input('step');
        $allocation_id = $request->input('allocation_id');

        if($allocation_id != null && $step_id != null){
            $allocation = Allocation::where('auto_num', $allocation_id)->where('is_allocated', "1")->get();
            if($allocation->first()){
                $patient_id = $allocation->first()->user_num;
                $user = Users::where('id', $patient_id)->get();
                $pacemaker = "0";
                if($user->first()){
                    $pacemaker = $user->first()->placemaker;
                }
                
                $origin_step = $allocation->first()->step;
                
                if( $origin_step == $step_id){
                    $res1 = Oximeter::where('allocation_id',$allocation_id)
                        ->where('step_id',$step_id)
                        ->delete();
                    $res1 = Blood::where('allocation_id',$allocation_id)
                        ->where('step_id',$step_id)
                        ->delete();
                        
                    $res1 = GSR::where('allocation_id',$allocation_id)
                        ->where('step_id',$step_id)
                        ->delete();                        
                }
                                                
                if($pacemaker == "1" && $step_id == 3){
                    DB::table('tbl_allocation')
                    ->where('auto_num', $allocation_id)
                    ->update(['step' => 4]);
                }else{
                    DB::table('tbl_allocation')
                    ->where('auto_num', $allocation_id)
                    ->update(['step' => $step_id]);
                }
                        
                $a = array('results'=>200,'msg'=>"success");
                return Response::json($a);
            }else{
                $check = Allocation::where('auto_num', $allocation_id)->get();
                if($check->first()){
                    $uid = $check->first()->user_num;
                    $data = Allocation::where('user_num', $uid)->where('is_allocated', 1)->get();
                    if($data->first()){
                        DB::table('tbl_allocation')
                        ->where('auto_num', $data->first()->auto_num)
                        ->update(['token_expired_alert' => 1]);
                    }
                }                
            }

        }
        
        $a = array('results'=>300,'msg'=>"failed");
        return Response::json($a);
                
    }

    public function completeStep(Request $request){        
        $allocation_id = $request->input('allocation_id');

        if($allocation_id != null ){
            DB::table('tbl_allocation')
            ->where('auto_num', $allocation_id)
            ->update(['step' => 8, 'is_allocated'=>0]);
            $a = array('results'=>200,'msg'=>"success");
            return Response::json($a);
        }else{
            $a = array('results'=>300,'msg'=>"failed");
            return Response::json($a);
        }
        
    }

    public function getDiabetReport(Request $request){
        
        $allocation_id = $request->input('allocation_id');
        $allocation = Allocation::where('auto_num', $allocation_id)->get();
        if($allocation->first()){
            
            $patient_id = $allocation->first()->user_num;
            $visit_form_id = $allocation->first()->visit_form_id;
            $diabet_risk_id = $allocation->first()->diabet_risk_id;       
            $patient = Users::where('id', $patient_id)->get()->first();
            if($patient){
                // -----------------------------------------   BMI Value   ---------------------------------------------------------------
                // get bmi values                
                $bmiData = $this->getBMI($patient->weight, $patient->user_height);
                // ---------------------------------------------    Type II Risk   ----------------------------------------------------------
                // age score
                $age_score = getAgeScore($patient->age);
                               
                $allocation_visit_form = AllocationVisitForm::where('id', $visit_form_id)->get()->first();
                $user_diabet = UserDiabet::where('id', $diabet_risk_id)->get()->first();
                $waist = $user_diabet->waist;
                $bpmeds = $user_diabet->bpmeds;
                $glucose = $user_diabet->glucose;
                $vegetable = $user_diabet->vegetable;
                $family = $user_diabet->family;
                
                // blood pressure medication score 
                $bpmeds_score = 0;
                if($bpmeds == 1){
                    $bpmeds_score = 2;
                }

                // glucose score 
                $glucose_score = 0;
                if($glucose == 1){
                    $glucose_score = 5;
                }
                // activity score 
                $activity_score = 0;                
                $activity = $allocation_visit_form->daily_activity;
                if($activity <= 4){
                    $activity_score =  2;
                }
                // vegetable score
                $vegetable_score = 0;
                if($vegetable == 0){
                    $vegetable_score = 1;                    
                }                
                // family score
                $family_score = 0;
                if($family == 2){
                    $family_score =  5;
                }else if($family == 1){
                    $family_score = 3;
                }                
                // waist score
                $waist_score = 0;
                if($patient->sex == "Male"){
                    if($waist >= 37 && $waist < 40){
                        $waist_score = 3;
                    }else if($waist >= 40){
                        $waist_score = 4;
                    }
                }else{
                    if($waist >= 31 && $waist < 35){
                        $waist_score = 3;
                    }else if($waist >= 35){
                        $waist_score = 4;
                    }
                }
                
                $diabet_risk_score = $age_score + $bmiData[3] + $bpmeds_score + $glucose_score 
                + $activity_score  +   $vegetable_score  + $family_score + $waist_score;
                $overall_blood = getRiskAndTitleColor($diabet_risk_score, 3, 8, 12, 20, 26,   12, 19, 15, 21 , 33);            
                $diabet_risk = $overall_blood[0];
                $diabet_risk_name = $overall_blood[1];
                $diabet_risk_color = $overall_blood[2];

                // 10 years risk
                if($patient->sex == "Male"){
                    if($diabet_risk_name == "Very Low"){
                        $year_risk  =   $year_risk = "0.3%";
                    }else if($diabet_risk_name == "Low"){
                        $year_risk  =   $year_risk = "0.8%";
                    }else if($diabet_risk_name == "Moderate"){
                        $year_risk  =   $year_risk = "2.6%";
                    }else if($diabet_risk_name == "High"){
                        $year_risk  =   $year_risk = "23.1%";
                    }else if($diabet_risk_name == "Very high"){
                        $year_risk  =   $year_risk = "~50%*";
                    }                    
                }else{
                    if($diabet_risk_name == "Very Low"){
                        $year_risk  =   $year_risk = "0.1%";
                    }else if($diabet_risk_name == "Low"){
                        $year_risk  =   $year_risk = "0.4%";
                    }else if($diabet_risk_name == "Moderate"){
                        $year_risk  =   $year_risk = "2.2%";
                    }else if($diabet_risk_name == "High"){
                        $year_risk  =   $year_risk = "14.1%";
                    }else if($diabet_risk_name == "Very high"){
                        $year_risk  =   $year_risk = "~50%*";
                    }    
                }            
                                
                $family_text = "No";        
                if($family == 1){
                    $family_text = "Yes - 2nd Degree Relative";
                }else if($family == 2){
                    $family_text = "Yes - 1st Degree Relative";
                }
                                
                $a = array('results'=>200,
                    'title'=> $diabet_risk_name,
                    'total'=> $diabet_risk_score,
                    'year_risk'=> $year_risk,
                    'age'=> [$patient->age, $age_score],
                    'bmi'=> [$bmiData[0], $bmiData[3]],
                    'waist'=> [$waist, $waist_score],
                    'bpmeds'=> [$bpmeds == 1 ? "Yes": "No", $bpmeds_score],
                    'glucose'=> [$glucose == 1?"Yes":"No", $glucose_score],
                    'vegetable'=> [$vegetable == 1?"Yes":"No", $vegetable_score],
                    'family'=> [$family_text, $family_score],
                    'activity'=> [$activity, $activity_score],
                    'risk_color'=> $diabet_risk_color,                    
                    'msg'=>"success");
                                    



                // blood pressure score
                $step3Data =  getLevelBood($allocation_id, $this->BASELINE);
                $step6Data =  getLevelBood($allocation_id, $this->STANDING);

                $SPRS = abs($step3Data[Config::get('constants.options.avg_systolic')] - $step6Data[Config::get('constants.options.avg_systolic')]);
                $DPRS = abs($step3Data[Config::get('constants.options.avg_diastolic')] - $step6Data[Config::get('constants.options.avg_diastolic')]);
        
                $overall_blood_score = $step3Data[Config::get('constants.options.score')] + $step6Data[ Config::get('constants.options.score') ];
                
                // base line section and standing section ...
                $BaselineTitleColor = getRiskAndTitleColor($step3Data[Config::get('constants.options.score')] , 1, 2, 3, 4 , 5 , 20 , 20, 20, 20, 20 );

                $baseline_systolic_color = "green-color";
                if($step3Data[Config::get('constants.options.avg_systolic')] > 120 && $step3Data[Config::get('constants.options.avg_systolic')] <= 130  ){
                    $baseline_systolic_color = "green-color";
                }else if($step3Data[Config::get('constants.options.avg_systolic')] > 130 && $step3Data[Config::get('constants.options.avg_systolic')] < 139){
                    $baseline_systolic_color = "yellow-color";
                }else if($step3Data[Config::get('constants.options.avg_systolic')] > 140 && $step3Data[Config::get('constants.options.avg_systolic')] < 179){
                    $baseline_systolic_color = "orange-color";
                }else if($step3Data[Config::get('constants.options.avg_systolic')] >= 180){
                    $baseline_systolic_color = "red-color";
                }

                $baseline_dyastolic_color = "green-color";
                if($step3Data[Config::get('constants.options.avg_diastolic')] > 80 && $step3Data[Config::get('constants.options.avg_diastolic')] < 89){
                    $baseline_dyastolic_color = "yellow-color";
                }else if($step3Data[Config::get('constants.options.avg_diastolic')] > 90 && $step3Data[Config::get('constants.options.avg_diastolic')] < 119){
                    $baseline_dyastolic_color = "orange-color";
                }else if($step3Data[Config::get('constants.options.avg_diastolic')] >= 120){
                    $baseline_dyastolic_color = "red-color";
                }
                
                $StandingTitleColor = getRiskAndTitleColor($step6Data[Config::get('constants.options.score')] , 1, 2, 3, 4 , 5 , 20 , 20, 20, 20, 20 );                         
                $standing_systolic_color = "green-color";
                if($step6Data[Config::get('constants.options.avg_systolic')] > 110 && $step6Data[Config::get('constants.options.avg_systolic')] < 119){
                    $standing_systolic_color = "green-color";
                }else if($step6Data[Config::get('constants.options.avg_systolic')] > 120 && $step6Data[Config::get('constants.options.avg_systolic')] < 129){
                    $standing_systolic_color = "yellow-color";
                }else if($step6Data[Config::get('constants.options.avg_systolic')] > 130 && $step6Data[Config::get('constants.options.avg_systolic')] < 169){
                    $standing_systolic_color = "orange-color";
                }else if($step6Data[Config::get('constants.options.avg_systolic')] >= 170){
                    $standing_systolic_color = "red-color";
                }

                $standing_dyastolic_color = "green-color";
                if($step6Data[Config::get('constants.options.avg_diastolic')] > 75 && $step6Data[Config::get('constants.options.avg_diastolic')] < 84){
                    $standing_dyastolic_color = "yellow-color";
                }else if($step6Data[Config::get('constants.options.avg_diastolic')] > 85 && $step6Data[Config::get('constants.options.avg_diastolic')] < 114){
                    $standing_dyastolic_color = "orange-color";
                }else if($step6Data[Config::get('constants.options.avg_diastolic')] >= 115){
                    $standing_dyastolic_color = "red-color";
                }

                 // BP Standing Response
                $StandingResponseScore = getSPRS_DPRS_Score($SPRS, $DPRS); // Get SPRS, DPRS Score 
                $overall_blood_score += $StandingResponseScore[0];                                                            
                $StandingResTitleColor = getRiskAndTitleColor( $StandingResponseScore[0] , 2, 4 , 6, 8 , 0 , 25 , 25, 25, 25, 0 );
                                        
                $step4Data =  getLevelBoodValsa($allocation_id, $this->VALSA);
                $step5Data =  getLevelBoodValsa($allocation_id, $this->DEEPBREADING);
                $overall_blood_score  +=  $step4Data[Config::get('constants.options.score')];
                

                $VAL_SCORE =  $step4Data[Config::get('constants.options.score')];
                $VAL_SYS_AVG = $step4Data[Config::get('constants.options.avg_systolic')];
                $VAL_DYA_AVG = $step4Data[Config::get('constants.options.avg_diastolic')];
                $ValsaTitleColor = getRiskAndTitleColor( $VAL_SCORE , 1, 3 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );


                $valsa_systolic_color = "green-color";
                if($step4Data[Config::get('constants.options.avg_systolic')] > 170 && $step4Data[Config::get('constants.options.avg_systolic')] < 179){
                    $valsa_systolic_color = "yellow-color";
                }else if($step4Data[Config::get('constants.options.avg_systolic')] > 180 && $step4Data[Config::get('constants.options.avg_systolic')] < 219){
                    $valsa_systolic_color = "orange-color";
                }else if($step4Data[Config::get('constants.options.avg_systolic')] >= 220){
                    $valsa_systolic_color = "red-color";
                }
                $valsa_dyastolic_color = "green-color";
                if($step4Data[Config::get('constants.options.avg_diastolic')] > 120 && $step4Data[Config::get('constants.options.avg_diastolic')] < 129 ){
                    $valsa_dyastolic_color = "yellow-color";
                }else if($step4Data[Config::get('constants.options.avg_diastolic')] > 130 && $step4Data[Config::get('constants.options.avg_diastolic')] < 159 ){
                    $valsa_dyastolic_color = "orange-color";
                }else if($step4Data[Config::get('constants.options.avg_diastolic')] >= 160){
                    $valsa_dyastolic_color = "red-color";
                }

                
                $SPRV = ($step3Data[Config::get('constants.options.avg_systolic')] - $step4Data[ Config::get('constants.options.avg_systolic') ]);                
                $SPRV_SCORE = 0;
                if( $SPRV > -20 && $SPRV <= -10){
                    $overall_blood_score += 2;
                    $SPRV_SCORE += 2;
                }else if($SPRV > -10 && $SPRV <= -5){
                    $overall_blood_score  += 3;
                    $SPRV_SCORE += 3;
                }else if($SPRV > -5 && $SPRV != 0){
                    $overall_blood_score  +=  4;
                    $SPRV_SCORE += 4;
                }
                $ValsaResTitleColor = getRiskAndTitleColor( $SPRV_SCORE , 0.1, 2 , 3, 4 , 0 , 25 , 25, 25, 25, 0 );
                                 
                $step5RRData = $this->getOximeterRR($allocation_id, $this->DEEPBREADING);
                $VRC5 = 0;
                if( count($step5RRData[0])  > 0){
                    $MaxMin = getLongShortRR($step5RRData[0]); 
                    if($MaxMin[1] != 0){
                        $VRC5 = $MaxMin[0] / $MaxMin[1];
                    }
                }

                $VRC4_Score = 0;
                $VRC6_Score = 0;
                $VRC5_Score = 0;                
                $color4 = "green-color";
                $color6 = "green-color";
                $color5 = "green-color";
                if($VRC5 < 1.2){
                    $overall_blood_score  += 1;
                    $VRC5_Score = 1;
                    $color5 = "yellow-color";
                }

                $VRC4 = 0;
                $step4RRData = $this->getOximeterRR($allocation_id, $this->VALSA);
                if( count($step4RRData[0])  > 0){
                    $MaxMin = getLongShortRR($step4RRData[0]); 
                    if($MaxMin[1] != 0){
                        $VRC4 = $MaxMin[0] / $MaxMin[1];
                    }
                }         
                if($VRC4 < 1.25){
                    $overall_blood_score  += 1;
                    $VRC4_Score = 1;
                    $color4 = "yellow-color";
                }

                $VRC6 = 0;
                $step6RRData = $this->getOximeterRR($allocation_id, $this->STANDING);
                if( count($step6RRData[0])  > 0){
                    $MaxMin = getLongShortRR($step6RRData[0]); 
                    if($MaxMin[1] != 0){
                        $VRC6 = $MaxMin[0] / $MaxMin[1];
                    }
                }
                if($VRC6 < 1.13){
                    $overall_blood_score  += 1;
                    $VRC6_Score = 1;
                    $color6 = "yellow-color";
                }                
                $para_score =   $VRC4_Score + $VRC6_Score + $VRC5_Score;    
                $paraTitleColor = getRiskAndTitleColor( $para_score , 0.1, 2 , 3, 0 , 0 , 33.3 , 33.3, 33.4, 0, 0 );                
                $overall_blood = getRiskAndTitleColor($overall_blood_score, 7, 15, 23, 30, 0, 23, 27, 27, 23 , 0);

                $blood_res = array('overall_blood_risk_percent' => $overall_blood[0],
                'overall_blood_risk_name' => $overall_blood[1],
                'overall_blood_risk_color' => $overall_blood[2],
                'baseline'=> [ round($step3Data[Config::get('constants.options.score')], 2),  
                round($step3Data[Config::get('constants.options.avg_systolic')], 2), 
                round($step3Data[Config::get('constants.options.avg_diastolic')], 2),
                $BaselineTitleColor[1],
                $step3Data[6],// color
                $BaselineTitleColor[0],
                $baseline_systolic_color,
                $baseline_dyastolic_color
                 ],
                'standing' => [ round($step6Data[Config::get('constants.options.score')], 2),  
                round($step6Data[Config::get('constants.options.avg_systolic')], 2), 
                round($step6Data[Config::get('constants.options.avg_diastolic')], 2),
                $StandingTitleColor[1],
                $step6Data[6] ,
                $StandingTitleColor[0],
                $standing_systolic_color,
                $standing_dyastolic_color
                ],
                'standingRes' => [round($SPRS , 2),  round($DPRS, 2), round($StandingResponseScore[0], 2) 
                , $StandingResTitleColor[1], $StandingResTitleColor[2]
                , $StandingResTitleColor[0], $StandingResponseScore[1] , $StandingResponseScore[2] ,  $StandingResponseScore[3] , $StandingResponseScore[4]],
                'valsalva' =>[round($VAL_SCORE, 2),  round($VAL_SYS_AVG, 2), round($VAL_DYA_AVG, 2) 
                , $ValsaTitleColor[1], $step4Data[6]
                , $step4Data[7],$valsa_systolic_color, $valsa_dyastolic_color],
                'valsalvaRes' =>[$SPRV_SCORE,  round($SPRV, 2)
                , $ValsaResTitleColor[1], $ValsaResTitleColor[2]
                , $ValsaResTitleColor[0]],
                'para' => [round($VRC4,2),  round($VRC6, 2) , round($VRC5, 2) 
                , round($para_score,2)
                , $color4, $color6 , $color5
                , $paraTitleColor[1], $paraTitleColor[2]
                , $paraTitleColor[0]]   );




                // para 
                // para                               
                //$step5RRData = $this->getOximeterRR($allocation_id, $this->DEEPBREADING);
                $EIR_Score = 0;$EIR = 0;
                if( count($step5RRData[0])  > 0){
                    $MaxMin = getLongShortRR($step5RRData[0]); 
                    if($MaxMin[1] != 0){
                        $EIR = $MaxMin[0] / $MaxMin[1];
                    }
                }                                                
                if($EIR < 1.2){
                    $EIR_Score = 1;
                }
                $EIR_ScoreTitleColor = getParaTitleColor( $EIR_Score , "sub");


                $VRC4 = 0;
                $step4RRData = $this->getOximeterRR($allocation_id, $this->VALSA);
                if( count($step4RRData[0])  > 0){
                    $MaxMin = getLongShortRR($step4RRData[0]); 
                    if($MaxMin[1] != 0){
                        $VRC4 = $MaxMin[0] / $MaxMin[1];
                    }
                }  
                $VRC4_Score = 0;
                if( $VRC4 < 1.25){
                    $VRC4_Score = 1;
                }
                $VRC4_ScoreTitleColor = getParaTitleColor( $VRC4_Score , "sub");

                $VRC6 = 0;
                $step6RRData = $this->getOximeterRR($allocation_id, $this->STANDING);
                if( count($step6RRData[0])  > 0){
                    $MaxMin = getLongShortRR($step6RRData[0]); 
                    if($MaxMin[1] != 0){
                        $VRC6 = $MaxMin[0] / $MaxMin[1];
                    }
                }

                $VRC6_Score = 0;
                if($VRC6 < 1.13){
                    $VRC6_Score = 1;
                }
                $VRC6_ScoreTitleColor = getParaTitleColor( $VRC6_Score , "sub");
                $ParaScore = $EIR_Score + $VRC4_Score + $VRC6_Score;
                $para = getParaTitleColor($ParaScore, "overall");

                

                $para_res = array('para' =>[$ParaScore, $para[0] , $para[1] , $para[2]],
                    'EIR' => [$EIR_Score, $EIR_ScoreTitleColor[0] , $EIR_ScoreTitleColor[1], $EIR_ScoreTitleColor[2] , round($EIR,2)],
                    'VRC4' => [$VRC4_Score, $VRC4_ScoreTitleColor[0] , $VRC4_ScoreTitleColor[1], $VRC4_ScoreTitleColor[2] , round($VRC4,2 )],
                    'VRC6' => [$VRC6_Score, $VRC6_ScoreTitleColor[0] , $VRC6_ScoreTitleColor[1], $VRC6_ScoreTitleColor[2] , round($VRC6, 2)]
                );


                // Skin 
                $GSR = $this->getGSR($allocation_id, $this->BASELINE);
                
                $Hand_Score = 0; $Feet_Score = 0;
                if($patient->sex == "Male"){
                    $Hand_Score = getMaleHandScore($patient->age, $GSR[0]);
                    $Feet_Score = getMaleFeetScore($patient->age, $GSR[1]);
                }else{
                    $Hand_Score = getFemaleHandScore($patient->age, $GSR[0]);
                    $Feet_Score = getFemaleFeetScore($patient->age, $GSR[1]);                    
                }

                $HandTitleColor = getSkinTitleColor($Hand_Score,"sub");
                $FeetTitleColor = getSkinTitleColor($Feet_Score,"sub");
                $SkinTitleColor = getSkinTitleColor($Hand_Score + $Feet_Score,"overall");

               
                $skin_res = array('skin' => [$Hand_Score + $Feet_Score, $SkinTitleColor[0] , $SkinTitleColor[1] , $SkinTitleColor[2]],
                    'hand' => [ $GSR[0], $Hand_Score , $HandTitleColor[0] , $HandTitleColor[1] , $HandTitleColor[2]],
                    'feet' => [ $GSR[1], $Feet_Score , $FeetTitleColor[0] , $FeetTitleColor[1] , $FeetTitleColor[2]]
                );
                if($patient->placemaker == 1){
                    $skin_res = array('skin' => [$Hand_Score + $Feet_Score, $SkinTitleColor[0] , $SkinTitleColor[1] , $SkinTitleColor[2]],
                        'hand' => [ "NA", "NA" , "NA", "NA" , "red-color"],
                        'feet' => [ "NA", "NA" , "NA", "NA" , "red-color"]
                    );
                }


                // ans 
                
                $HR = $step3Data[Config::get('constants.options.avg_heart_rate')]; // mean heard rate during step 3.

                $ANS_Score = 0;
                $HR_Score =  getANSHeartScore($patient->sex, $patient->age, $HR);
                $ANS_Score += $HR_Score;
                $HR_Per_Title_Color =  getRiskAndTitleColor($HR_Score, 1, 2, 3, 4, 5, 20, 20, 20, 20 , 20);
                               
                $SDNN = $this->getSDNN($allocation_id, $this->BASELINE);        // Get SDNN Value
                $SDNN_SCORE = getSDNNScore($patient->age, $SDNN);    // Get SDNN Score 
                $ANS_Score  +=  $SDNN_SCORE;
                $SDNN_Per_Title_Color =  getRiskAndTitleColor($SDNN_SCORE, 0.1, 1, 3, 0, 0, 33.3, 33.3, 33.4, 0, 0);                
 
                $RMSSD = $this->getRMSSD($allocation_id, $this->BASELINE);      // Get RMSSD Value
                $RMSSD_SCORE = getRMSSDScore($patient->age, $RMSSD);  // Get RMSSD Score  
                $ANS_Score  +=  $RMSSD_SCORE;
                $RMSSD_Per_Title_Color =  getRiskAndTitleColor($RMSSD_SCORE, 0.1, 1, 3, 0, 0, 33.3, 33.3, 33.4, 0, 0);
                              
                 $step3RRData = getRR($allocation_id, $this->BASELINE);    
                 $AVG_RR  = $step3RRData[2];                 // Get Avg RR Value
                 $AVG_RR_Score = getAvgRRScore($AVG_RR);            // Get Avg RR Score 
                 $ANS_Score += $AVG_RR_Score;
                 $AVGRR_Per_Title_Color =  getRiskAndTitleColor($AVG_RR_Score, 0.1, 1, 3, 0, 0, 33.3, 33.3, 33.4, 0, 0);
                
                 $PERCENT_MORE_THAN_50 = $step3RRData[3];                            // Get Vale
                 $PERCENT_MORE_THAN_50_Score = get50Score($PERCENT_MORE_THAN_50);    // Get Score 
                 $ANS_Score += $PERCENT_MORE_THAN_50_Score;
                 $More50_Per_Title_Color =  getRiskAndTitleColor($PERCENT_MORE_THAN_50_Score, 0.1, 1, 3, 0, 0, 33.3, 33.3, 33.4, 0, 0);
                              
                 $AVG_OXYGEN = $step3RRData[1];   
                 $AVG_OXYGEN_Score = 0;
                 $Oxygen_Per = 0; $Oxygen_Title = "Low"; $Oxygen_Color = "green-color";
                 if($AVG_OXYGEN < 94 ){
                     $AVG_OXYGEN_Score += 1;
                     $Oxygen_Per = 100; $Oxygen_Title = "High"; $Oxygen_Color = "red-color";
                 }
                 $ANS_Score += $AVG_OXYGEN_Score;
                 $ans_dysfunction = getRiskAndTitleColor($ANS_Score, 5, 9, 14, 18, 0, 28, 22, 28, 22 , 0);



                $ans_res = array('heart_rate' => [round($HR,2), $HR_Score, $HR_Per_Title_Color[0] , $HR_Per_Title_Color[1] ,  $HR_Per_Title_Color[2] ],
                    'SDNN' => [round($SDNN , 2),  $SDNN_SCORE, $SDNN_Per_Title_Color[0] , $SDNN_Per_Title_Color[1] ,  $SDNN_Per_Title_Color[2] ],
                    'RMSSD' => [round($RMSSD, 2), $RMSSD_SCORE, $RMSSD_Per_Title_Color[0] , $RMSSD_Per_Title_Color[1] ,  $RMSSD_Per_Title_Color[2] ],
                    'AVG_RR' => [round($AVG_RR, 2), $AVG_RR_Score, $AVGRR_Per_Title_Color[0] , $AVGRR_Per_Title_Color[1] ,  $AVGRR_Per_Title_Color[2] ],
                    'More50' => [round($PERCENT_MORE_THAN_50, 2) , $PERCENT_MORE_THAN_50_Score, $More50_Per_Title_Color[0] , $More50_Per_Title_Color[1] ,  $More50_Per_Title_Color[2] ],
                    'SPO2' => [ round($AVG_OXYGEN, 2) ,$AVG_OXYGEN_Score,  $Oxygen_Per , $Oxygen_Title ,  $Oxygen_Color ],
                    'ans' => [ $ANS_Score ,  $ans_dysfunction[0] , $ans_dysfunction[1] ,  $ans_dysfunction[2] ]                
                );


                // adrenergic

                if($step4Data[Config::get('constants.options.min_heart_rate')] != 0){
                    $VRC4 = $step4Data[Config::get('constants.options.max_heart_rate')] / $step4Data[Config::get('constants.options.min_heart_rate')];
                }else{
                    $VRC4 = 0;
                }                
                if( $step6Data[Config::get('constants.options.min_heart_rate')] != 0){
                    $VRC6 = $step6Data[Config::get('constants.options.max_heart_rate')] / $step6Data[Config::get('constants.options.min_heart_rate')];
                }else{
                    $VRC6 = 0;
                }
                $SPRV = ($step3Data[Config::get('constants.options.avg_systolic')] - $step4Data[ Config::get('constants.options.avg_systolic') ]);

                // Adrenergic 
                $AVG_Systolic_Baseline = $step3Data[Config::get('constants.options.avg_systolic')];
                $AVG_Diastolic_Baseline = $step3Data[Config::get('constants.options.avg_diastolic')];                
                $AVG_Systolic_Standing = $step6Data[Config::get('constants.options.avg_systolic')];
                $AVG_Diastolic_Standing = $step6Data[Config::get('constants.options.avg_diastolic')];                

                $BaselineSysScore = getBaselineFromSys($AVG_Systolic_Baseline);
                $BaselineSysScoreTitleColor = getRiskAndTitleColor( $BaselineSysScore , 1, 3 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );

                $BaselineDiaScore = getBaselineFromDia($AVG_Diastolic_Baseline);
                $BaselineDiaScoreTitleColor = getRiskAndTitleColor( $BaselineDiaScore , 0.1, 2 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );

                $StandingSysScore = getStandingFromSys($AVG_Systolic_Standing);
                $StandingSysScoreTitleColor = getRiskAndTitleColor( $StandingSysScore , 1, 3 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );

                $StandingDiaScore = getStandingFromDia($AVG_Diastolic_Standing);                
                $StandingDiaScoreTitleColor = getRiskAndTitleColor( $StandingDiaScore , 0.1, 2 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );

                $SPRV_Score = getValsalvaScore($SPRV);
                $SPRV_ScoreTitleColor = getRiskAndTitleColor( $SPRV_Score , 1, 3 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );                

                $SPRS = $step3Data[Config::get('constants.options.avg_systolic')] - $step6Data[Config::get('constants.options.avg_systolic')];
                $SPRS_Score = getSPRSScore($SPRS);
                $SPRS_ScoreTitleColor = getRiskAndTitleColor( $SPRS_Score , 1, 3 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );

                $DPRS =  $step3Data[Config::get('constants.options.avg_diastolic')] - $step6Data[Config::get('constants.options.avg_diastolic')];
                $DPRS_Score = getDPRSScore($DPRS);
                $DPRS_ScoreTitleColor = getRiskAndTitleColor( $DPRS_Score , 1, 3 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );
               
                $AdrenergicScore = $BaselineSysScore + $BaselineDiaScore + $StandingSysScore + $StandingDiaScore + $SPRV_Score + $SPRS_Score + $DPRS_Score ;
                $adrenergic = getRiskAndTitleColor($AdrenergicScore, 7, 15, 23, 30, 0, 24, 26, 26, 24 , 0);
               
                $adr_res = array(
                    'adrenergic' => [$AdrenergicScore, $adrenergic[0] , $adrenergic[1] , $adrenergic[2]],
                    'BaselineSys' => [$BaselineSysScore, $BaselineSysScoreTitleColor[0] , $BaselineSysScoreTitleColor[1], $BaselineSysScoreTitleColor[2], round($AVG_Systolic_Baseline,2) ],
                    'BaselineDia' => [$BaselineDiaScore, $BaselineDiaScoreTitleColor[0] , $BaselineDiaScoreTitleColor[1], $BaselineDiaScoreTitleColor[2], round($AVG_Diastolic_Baseline, 2) ],
                    'StandingSys' => [$StandingSysScore, $StandingSysScoreTitleColor[0] , $StandingSysScoreTitleColor[1], $StandingSysScoreTitleColor[2], round($AVG_Systolic_Standing, 2) ],
                    'StandingDia' => [$StandingDiaScore, $StandingDiaScoreTitleColor[0] , $StandingDiaScoreTitleColor[1], $StandingDiaScoreTitleColor[2], round($AVG_Diastolic_Standing,2) ],
                    'SPRV' =>  [$SPRV_Score, $SPRV_ScoreTitleColor[0] , $SPRV_ScoreTitleColor[1], $SPRV_ScoreTitleColor[2] , round($SPRV,2)],
                    'SPRS' =>  [$SPRS_Score, $SPRS_ScoreTitleColor[0] , $SPRS_ScoreTitleColor[1], $SPRS_ScoreTitleColor[2] , round($SPRS,2)],
                    'DPRS' =>  [$DPRS_Score, $DPRS_ScoreTitleColor[0] , $DPRS_ScoreTitleColor[1], $DPRS_ScoreTitleColor[2] , round($DPRS,2)]
                );



                // card 
                $AVG_RR  = $step3RRData[2];                 // Get Avg RR Value
                $AVG_RR_Score = getAvgRRScore($AVG_RR);            // Get Avg RR Score      
                $RR = getRiskAndTitleColor( $AVG_RR_Score , 0.1, 1 , 3, 0 , 0 , 33.3 , 33.3, 33.4, 0, 0 );

                $VRC4 = 0;
                if($step4Data[Config::get('constants.options.min_heart_rate')] != 0){
                    $VRC4 = $step4Data[Config::get('constants.options.max_heart_rate')] / $step4Data[Config::get('constants.options.min_heart_rate')];
                }
                
                $VRC6 = 0;
                if($step6Data[Config::get('constants.options.min_heart_rate')] != 0){
                    $VRC6 = $step6Data[Config::get('constants.options.max_heart_rate')] / $step6Data[Config::get('constants.options.min_heart_rate')];
                }
                
                $VRC4_Score = 0;
                if( $VRC4 < 1.25){
                    $VRC4_Score = 1;
                }
                $VRC4_Title_Color = getValsaTitleColor( $VRC4_Score );
                $VRC6_Score = 0;
                if($VRC6 < 1.13){
                    $VRC6_Score = 1;
                }
                $VRC6_Title_Color = getValsaTitleColor( $VRC6_Score );

                $SPRS = $step3Data[Config::get('constants.options.avg_systolic')] - $step6Data[Config::get('constants.options.avg_systolic')];
                $SPRS_Score = getSPRSScore($SPRS);
                $SPRS_Title_Color = getRiskAndTitleColor( $SPRS_Score , 1, 3 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );

                $DPRS =  $step3Data[Config::get('constants.options.avg_diastolic')] - $step6Data[Config::get('constants.options.avg_diastolic')];
                $DPRS_Score = getDPRSScore($DPRS);
                $DPRS_Title_Color = getRiskAndTitleColor( $DPRS_Score , 1, 3 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );

                $step7Data =  getLevelBood($allocation_id, $this->HANDGRIP);
                $SPRS7 = 0;
                if( $step7Data[Config::get('constants.options.avg_systolic')] != 0 && $step3Data[Config::get('constants.options.avg_systolic')] != 0){
                    $SPRS7 = $step3Data[Config::get('constants.options.avg_systolic')] - $step7Data[Config::get('constants.options.avg_systolic')];
                }

                $SPRS7_Score = 0;
                if($SPRS7 < 11){
                    $SPRS7_Score += 3;
                }else if($SPRS7 >= 11 &&  $SPRS7 < 16){
                    $SPRS7_Score += 1;
                }
                $SPRS7_Title_Color = getRiskAndTitleColor( $SPRS7_Score , 0.1, 1 , 3, 0 , 0 , 33.3 , 33.3, 33.4, 0, 0 );


                $CardScore = $AVG_RR_Score + $VRC4_Score + $VRC6_Score + $SPRS_Score + $DPRS_Score + $SPRS7_Score;
                $card = getRiskAndTitleColor($CardScore, 4, 9, 13, 18, 0, 22, 28, 22, 28 , 0);

            

                $card_res = array(
                    'card' => [$CardScore, $card[0] , $card[1] , $card[2]],
                    'RR' => [$AVG_RR_Score, $RR[0] , $RR[1], $RR[2] , round($AVG_RR, 2)],
                    'VRC4' =>  [$VRC4_Score, $VRC4_Title_Color[0] , $VRC4_Title_Color[1], $VRC4_Title_Color[2] , round($VRC4, 2)],
                    'VRC6' =>  [$VRC6_Score, $VRC6_Title_Color[0] , $VRC6_Title_Color[1], $VRC6_Title_Color[2] , round($VRC6, 2)],
                    'SPRS' =>  [$SPRS_Score, $SPRS_Title_Color[0] , $SPRS_Title_Color[1], $SPRS_Title_Color[2] , round($SPRS, 2)],
                    'DPRS' => [$DPRS_Score, $DPRS_Title_Color[0] , $DPRS_Title_Color[1], $DPRS_Title_Color[2] , round($DPRS, 2)],
                    'SPRS7' =>  [$SPRS7_Score, $SPRS7_Title_Color[0] , $SPRS7_Title_Color[1], $SPRS7_Title_Color[2] , round($SPRS7, 2)]
                );

                $a = array('results'=>200, 'diabet'=>$a, 'blood'=>$blood_res
                 , 'para' => $para_res , 'skin' => $skin_res , 'ans' => $ans_res, 'adr'=>$adr_res, 'card' =>$card_res);  
                return Response::json($a);
            }                
        }

        $a = array('results'=>300,'msg'=>"failed");
        return Response::json($a);
        
    }
    
}


