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
use App\Allocation;
use App\Blood;
use App\AllocationVisitForm;
use App\UserDiabet;
use App\Oximeter;
use Config;
use Session;
use App\Helpers\GSR;


class SubreportController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
  
    public function getDiabetReport($id = '', Request $request = null){

        $allocation_id = $id;// $request->input('patient_id');
        if($allocation_id == null || $allocation_id == ''){
            $allocation_id = $request->input('allocation_id');
        }
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
                    if($waist >= 94 && $waist < 102){
                        $waist_score = 3;
                    }else if($waist >= 102){
                        $waist_score = 4;
                    }
                }else{
                    if($waist >= 80 && $waist < 88){
                        $waist_score = 3;
                    }else if($waist >= 88){
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

                return view('doctor.review.sub_diabet')
                ->with('allocation', $allocation->first())
                ->with('patient', $patient)
                ->with('weight_status', $bmiData[1])
                ->with('color', $bmiData[2])
                ->with('diabet_risk_score', $diabet_risk_score)
                ->with('diabet_risk_percent', $diabet_risk)
                ->with('diabet_risk_name', $diabet_risk_name)
                ->with('diabet_risk_color', $diabet_risk_color)
                ->with('year_risk', $year_risk)                                
                ->with('age', [$patient->age, $age_score])
                ->with('bmi', [$bmiData[0], $bmiData[3]])
                ->with('waist', [$waist, $waist_score])
                ->with('bpmeds', [$bpmeds, $bpmeds_score])
                ->with('glucose', [$glucose, $glucose_score])
                ->with('vegetable', [$vegetable, $vegetable_score])
                ->with('family', [$family, $family_score])
                ->with('activity', [$activity, $activity_score]);
            }                
        }
        redirect()->back();
    }

    // --------------------------------------------------------- Blood Pressure Sub Report  -------------------------------------------------------
    public function getBloodPressureReport($id = '', Request $request = null){

        $allocation_id = $id;// $request->input('patient_id');
        if($allocation_id == null || $allocation_id == ''){
            $allocation_id = $request->input('allocation_id');
        }

        $allocation = Allocation::where('auto_num', $allocation_id)->get();
        if($allocation->first()){
            
            $patient_id = $allocation->first()->user_num;
            $visit_form_id = $allocation->first()->visit_form_id;
            $diabet_risk_id = $allocation->first()->diabet_risk_id;  

            $patient = Users::where('id', $patient_id)->get()->first();
            if($patient){

                // get BMI data 
                $bmiData = $this->getBMI($patient->weight, $patient->user_height);
                
                $step3Data =  getLevelBood($allocation_id, 3);
                $step6Data =  getLevelBood($allocation_id, 6);

                $SPRS = abs($step3Data[Config::get('constants.options.avg_systolic')] - $step6Data[Config::get('constants.options.avg_systolic')]);
                $DPRS = abs($step3Data[Config::get('constants.options.avg_diastolic')] - $step6Data[Config::get('constants.options.avg_diastolic')]);
        
                $overall_blood_score = $step3Data[Config::get('constants.options.score')] + $step6Data[ Config::get('constants.options.score') ];
                
                // base line section
                $BaselineTitleColor = getRiskAndTitleColor($step3Data[Config::get('constants.options.score')] , 1, 2, 3, 4 , 5 , 20 , 20, 20, 20, 20 );
                $baseline_systolic_color = "green-color";
                if($step3Data[Config::get('constants.options.avg_systolic')] > 130 && $step3Data[Config::get('constants.options.avg_systolic')] < 139){
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


                // standing section
                $StandingTitleColor = getRiskAndTitleColor($step6Data[Config::get('constants.options.score')] , 1, 2, 3, 4 , 5 , 20 , 20, 20, 20, 20 );          
                $StandingResponseScore = getSPRS_DPRS_Score($SPRS, $DPRS); // Get SPRS, DPRS Score 
                $standing_systolic_color = "green-color";
                if($step6Data[Config::get('constants.options.avg_systolic')] > 120 && $step6Data[Config::get('constants.options.avg_systolic')] < 129){
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

                $overall_blood_score += $StandingResponseScore[0];
                                                            
                $StandingResTitleColor = getRiskAndTitleColor( $StandingResponseScore[0] , 2, 4 , 6, 8 , 0 , 25 , 25, 25, 25, 0 );

                
                        
                $step4Data =  getLevelBoodValsa($allocation_id, 4);
                $step5Data =  getLevelBoodValsa($allocation_id, 5);
                $overall_blood_score  +=  $step4Data[Config::get('constants.options.score')];

                $SPRV = ($step3Data[Config::get('constants.options.avg_systolic')] - $step4Data[ Config::get('constants.options.avg_systolic') ]);
                $SPRV_SCORE =  $step4Data[Config::get('constants.options.score')];
                $SPRV_SYS_AVG = $step4Data[Config::get('constants.options.avg_systolic')];
                $SPRV_DYA_AVG = $step4Data[Config::get('constants.options.avg_diastolic')];

                $ValsaTitleColor = getRiskAndTitleColor( $SPRV_SCORE , 1, 3 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );

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


                $DPRV = ($step3Data[Config::get('constants.options.avg_diastolic')] - $step4Data[ Config::get('constants.options.avg_diastolic') ]);
                $DPRV_SCORE = 0;
                if( $DPRV > -20 && $DPRV <= -10){
                    $overall_blood_score += 2;
                    $DPRV_SCORE += 2;
                }else if($DPRV > -10 && $DPRV <= -5){
                    $overall_blood_score  += 3;
                    $DPRV_SCORE += 3;
                }else if($DPRV > -5 && $DPRV != 0){
                    $overall_blood_score  +=  4;
                    $DPRV_SCORE += 4;
                }
                $ValsaResTitleColor = getRiskAndTitleColor( $DPRV_SCORE , 0.1, 2 , 3, 4 , 0 , 25 , 25, 25, 25, 0 );
                
                

                $VRC4_Score = 0;
                $VRC6_Score = 0;
                $VRC5_Score = 0;
                if($step5Data[Config::get('constants.options.min_heart_rate')] != 0){
                    $VRC5 = $step5Data[Config::get('constants.options.max_heart_rate')] / $step5Data[Config::get('constants.options.min_heart_rate')];
                }else{
                    $VRC5 = 0;
                }
                $color4 = "green-color";
                $color6 = "green-color";
                $color5 = "green-color";
                if($VRC5 >= 1.2){
                    $overall_blood_score  += 1;
                    $VRC5_Score = 1;
                    $color5 = "yellow-color";
                }

                if($step4Data[Config::get('constants.options.min_heart_rate')] != 0){
                    $VRC4 = $step4Data[Config::get('constants.options.max_heart_rate')] / $step4Data[Config::get('constants.options.min_heart_rate')];
                }else{
                    $VRC4 = 0;
                }                            
                if($VRC4 >= 1.25){
                    $overall_blood_score  += 1;
                    $VRC4_Score = 1;
                    $color4 = "yellow-color";
                }
                if( $step6Data[Config::get('constants.options.min_heart_rate')] != 0){
                    $VRC6 = $step6Data[Config::get('constants.options.max_heart_rate')] / $step6Data[Config::get('constants.options.min_heart_rate')];
                }else{
                    $VRC6 = 0;
                }        
                if($VRC6 >= 1.13){
                    $overall_blood_score  += 1;
                    $VRC6_Score = 1;
                    $color6 = "yellow-color";
                }         
                $para_score =   $VRC4_Score + $VRC6_Score + $VRC5_Score;    
                $paraTitleColor = getRiskAndTitleColor( $para_score , 0.1, 2 , 3, 0 , 0 , 33.3 , 33.3, 33.4, 0, 0 );

                $overall_blood = getRiskAndTitleColor($overall_blood_score, 7, 15, 23, 30, 0, 23, 27, 27, 23 , 0);
                                
                return view('doctor.review.sub_blood_pressure')
                    ->with('allocation', $allocation->first())
                    ->with('patient', $patient)
                    ->with('bmi', $bmiData[0])
                    ->with('weight_status', $bmiData[1])
                    ->with('color', $bmiData[2])  
                    ->with('overall_blood_risk_score', $overall_blood_score)
                    ->with('overall_blood_risk_percent', $overall_blood[0])
                    ->with('overall_blood_risk_name', $overall_blood[1])
                    ->with('overall_blood_risk_color', $overall_blood[2])
                    ->with('baseline', [ round($step3Data[Config::get('constants.options.score')], 2),  
                            round($step3Data[Config::get('constants.options.avg_systolic')], 2), 
                            round($step3Data[Config::get('constants.options.avg_diastolic')], 2),
                            $BaselineTitleColor[1],
                            $BaselineTitleColor[2],
                            $BaselineTitleColor[0],
                            $baseline_systolic_color,
                            $baseline_dyastolic_color
                             ])
                    ->with('standing', [ round($step6Data[Config::get('constants.options.score')], 2),  
                            round($step6Data[Config::get('constants.options.avg_systolic')], 2), 
                            round($step6Data[Config::get('constants.options.avg_diastolic')], 2),
                            $StandingTitleColor[1],
                            $StandingTitleColor[2] ,
                            $StandingTitleColor[0],
                            $standing_systolic_color,
                            $standing_dyastolic_color
                            ])
                    ->with('standingRes', [round($SPRS , 2),  round($DPRS, 2), round($StandingResponseScore[0], 2) 
                    , $StandingResTitleColor[1], $StandingResTitleColor[2]
                    , $StandingResTitleColor[0], $StandingResponseScore[1] , $StandingResponseScore[2] ,  $StandingResponseScore[3] , $StandingResponseScore[4]
                    ])
                    ->with('valsalva', [round($SPRV_SCORE, 2),  round($SPRV_SYS_AVG, 2), round($SPRV_DYA_AVG, 2) 
                    , $ValsaTitleColor[1], $ValsaTitleColor[2]
                    , $ValsaTitleColor[0],$valsa_systolic_color, $valsa_dyastolic_color
                    ])
                    ->with('valsalvaRes', [$DPRV_SCORE,  round($DPRV, 2)
                    , $ValsaResTitleColor[1], $ValsaResTitleColor[2]
                    , $ValsaResTitleColor[0]
                    ])
                    ->with('para', [round($VRC4,2),  round($VRC6, 2) , round($VRC5, 2) 
                    , round($para_score,2)
                    , $color4, $color6 , $color5
                    , $paraTitleColor[1], $paraTitleColor[2]
                    , $paraTitleColor[0]
                    ]);


            }                      
        }
        redirect()->back();
    }


    public function getSkin($id = '', Request $request = null){
        $allocation_id = $id;// $request->input('patient_id');
        if($allocation_id == null || $allocation_id == ''){
            $allocation_id = $request->input('allocation_id');
        }
        $allocation = Allocation::where('auto_num', $allocation_id)->get();
        if($allocation->first()){            
            $patient_id = $allocation->first()->user_num;            
            $patient = Users::where('id', $patient_id)->get()->first();
            if($patient){
                $bmiData = $this->getBMI($patient->weight, $patient->user_height);
                // Skin Report 
                $GSR = $this->getGSR($allocation_id, 3);
                //$Female_Hand_Score = 0; $Female_Feet_Score = 0;
                $Hand_Score = 0; $Feet_Score = 0;
                if($patient->sex == "Male"){
                    $Hand_Score = getMaleHandScore($patient->age, $GSR);
                    $Feet_Score = getMaleFeetScore($patient->age, $GSR);
                }else{
                    $Hand_Score = getFemaleHandScore($patient->age, $GSR);
                    $Feet_Score = getFemaleFeetScore($patient->age, $GSR);                    
                }
                $SkinTitleColor = getRiskAndTitleColor($Hand_Score + $Feet_Score, 1, 2, 4, 0, 0, 25, 25, 50, 0 , 0);
                return view('doctor.review.sub_skin')
                ->with('allocation', $allocation->first())
                ->with('patient', $patient)
                ->with('bmi', $bmiData[0])->with('weight_status', $bmiData[1])->with('color', $bmiData[2])
                ->with('skin', [$Hand_Score + $Feet_Score, $SkinTitleColor[0] , $SkinTitleColor[1] , $SkinTitleColor[2]]) // Score, Percentage , 
                ->with('hand', [ $GSR, $Hand_Score , $SkinTitleColor[0] , $SkinTitleColor[1] , $SkinTitleColor[2]]) // Real Value, Score, Percent, Title , Title Color
                ->with('feet', [ $GSR, $Feet_Score , $SkinTitleColor[0] , $SkinTitleColor[1] , $SkinTitleColor[2]]); 

            }
        }
        redirect()->back();
    }

    public function getAns($id = '', Request $request = null){
        $allocation_id = $id;// $request->input('patient_id');
        if($allocation_id == null || $allocation_id == ''){
            $allocation_id = $request->input('allocation_id');
        }
        $allocation = Allocation::where('auto_num', $allocation_id)->get();
        if($allocation->first()){            
            $patient_id = $allocation->first()->user_num;            
            $patient = Users::where('id', $patient_id)->get()->first();
            if($patient){
                $bmiData = $this->getBMI($patient->weight, $patient->user_height);
                // Get ANS Dysfunction
                $step3Data =  getLevelBood($allocation_id, 3);
                $HR = $step3Data[Config::get('constants.options.avg_heart_rate')]; // mean heard rate during step 3.

                $ANS_Score = 0;
                $HR_Score =  getANSHeartScore($patient->sex, $patient->age, $HR);
                $ANS_Score += $HR_Score;
                $HR_Per_Title_Color =  getRiskAndTitleColor($HR_Score, 1, 2, 3, 4, 5, 20, 20, 20, 20 , 20);
                               
                $SDNN = $this->getSDNN();        // Get SDNN Value
                $SDNN_SCORE = getSDNNScore($patient->age, $SDNN);    // Get SDNN Score 
                $ANS_Score  +=  $SDNN_SCORE;
                $SDNN_Per_Title_Color =  getRiskAndTitleColor($SDNN_SCORE, 0.1, 1, 3, 0, 0, 33.3, 33.3, 33.4, 0, 0);                
 
                $RMSSD = $this->getRMSSD();      // Get RMSSD Value
                $RMSSD_SCORE = getRMSSDScore($patient->age, $RMSSD);  // Get RMSSD Score  
                $ANS_Score  +=  $RMSSD_SCORE;
                $RMSSD_Per_Title_Color =  getRiskAndTitleColor($RMSSD_SCORE, 0.1, 1, 3, 0, 0, 33.3, 33.3, 33.4, 0, 0);
                              
                 $step3RRData = getRR($allocation_id, 3);    
                 $AVG_RR  = $step3RRData[2];                 // Get Avg RR Value
                 $AVG_RR_Score = getAvgRRScore($AVG_RR);            // Get Avg RR Score 
                 $ANS_Score += $AVG_RR_Score;
                 $AVGRR_Per_Title_Color =  getRiskAndTitleColor($AVG_RR_Score, 0.1, 1, 3, 0, 0, 33.3, 33.3, 33.4, 0, 0);
                
                 $PERCENT_MORE_THAN_50 = $step3RRData[3];                            // Get Vale
                 $PERCENT_MORE_THAN_50_Score = get50Score($PERCENT_MORE_THAN_50);    // Get Score 
                 $ANS_Score += $PERCENT_MORE_THAN_50_Score;
                 $More50_Per_Title_Color =  getRiskAndTitleColor($PERCENT_MORE_THAN_50_Score, 0.1, 1, 3, 0, 0, 33.3, 33.3, 33.4, 0, 0);
                              
                 $AVG_OXYGEN = $step3RRData[2];                
                 $AVG_OXYGEN_Score = 0;
                 $Oxygen_Per = 50; $Oxygen_Title = "Low"; $Oxygen_Color = "green-color";
                 if($AVG_OXYGEN < 94 ){
                     $AVG_OXYGEN_Score += 1;
                     $Oxygen_Per = 100; $Oxygen_Title = "High"; $Oxygen_Color = "red-color";
                 }
                 $ANS_Score += $AVG_OXYGEN_Score;


                 $ans_dysfunction = getRiskAndTitleColor($ANS_Score, 5, 9, 14, 18, 0, 28, 22, 28, 22 , 0);

                return view('doctor.review.sub_ans_dysfunction')
                ->with('allocation', $allocation->first())
                ->with('patient', $patient)
                ->with('bmi', $bmiData[0])->with('weight_status', $bmiData[1])->with('color', $bmiData[2])
                ->with('heart_rate', [round($HR,2), $HR_Score, $HR_Per_Title_Color[0] , $HR_Per_Title_Color[1] ,  $HR_Per_Title_Color[2] ])
                ->with('SDNN', [round($SDNN , 2),  $SDNN_SCORE, $SDNN_Per_Title_Color[0] , $SDNN_Per_Title_Color[1] ,  $SDNN_Per_Title_Color[2] ])
                ->with('RMSSD', [round($RMSSD, 2), $RMSSD_SCORE, $RMSSD_Per_Title_Color[0] , $RMSSD_Per_Title_Color[1] ,  $RMSSD_Per_Title_Color[2] ])
                ->with('AVG_RR', [round($AVG_RR, 2), $AVG_RR_Score, $AVGRR_Per_Title_Color[0] , $AVGRR_Per_Title_Color[1] ,  $AVGRR_Per_Title_Color[2] ])
                ->with('More50', [round($PERCENT_MORE_THAN_50, 2) , $PERCENT_MORE_THAN_50_Score, $More50_Per_Title_Color[0] , $More50_Per_Title_Color[1] ,  $More50_Per_Title_Color[2] ])                
                ->with('SPO2', [ round($AVG_OXYGEN, 2) ,$AVG_OXYGEN_Score,  $Oxygen_Per , $Oxygen_Title ,  $Oxygen_Color ])
                ->with('ans', [ $ANS_Score ,  $ans_dysfunction[0] , $ans_dysfunction[1] ,  $ans_dysfunction[2] ]);
                   
            }
        }
        redirect()->back();
    }

    
    public function getAdrenergic($id = '', Request $request = null){

        $allocation_id = $id;// $request->input('patient_id');
        if($allocation_id == null || $allocation_id == ''){
            $allocation_id = $request->input('allocation_id');
        }

        $allocation = Allocation::where('auto_num', $allocation_id)->get();
        if($allocation->first()){            
            $patient_id = $allocation->first()->user_num;            
            $patient = Users::where('id', $patient_id)->get()->first();
            if($patient){
                $bmiData = $this->getBMI($patient->weight, $patient->user_height);          
                $step3Data =  getLevelBood($allocation_id, 3);
                $step4Data =  getLevelBood($allocation_id, 4);
                $step6Data =  getLevelBood($allocation_id, 6);
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

                return view('doctor.review.sub_adrenergic')
                ->with('allocation', $allocation->first())
                ->with('patient', $patient)
                ->with('bmi', $bmiData[0])->with('weight_status', $bmiData[1])->with('color', $bmiData[2])
                ->with('adrenergic', [$AdrenergicScore, $adrenergic[0] , $adrenergic[1] , $adrenergic[2]])
                ->with('BaselineSys', [$BaselineSysScore, $BaselineSysScoreTitleColor[0] , $BaselineSysScoreTitleColor[1], $BaselineSysScoreTitleColor[2], round($AVG_Systolic_Baseline,2) ])
                ->with('BaselineDia', [$BaselineDiaScore, $BaselineDiaScoreTitleColor[0] , $BaselineDiaScoreTitleColor[1], $BaselineDiaScoreTitleColor[2], round($AVG_Diastolic_Baseline, 2) ])
                ->with('StandingSys', [$StandingSysScore, $StandingSysScoreTitleColor[0] , $StandingSysScoreTitleColor[1], $StandingSysScoreTitleColor[2], round($AVG_Systolic_Standing, 2) ])
                ->with('StandingDia', [$StandingDiaScore, $StandingDiaScoreTitleColor[0] , $StandingDiaScoreTitleColor[1], $StandingDiaScoreTitleColor[2], round($AVG_Diastolic_Standing,2) ])
                ->with('SPRV', [$SPRV_Score, $SPRV_ScoreTitleColor[0] , $SPRV_ScoreTitleColor[1], $SPRV_ScoreTitleColor[2] , round($SPRV,2)])
                ->with('SPRS', [$SPRS_Score, $SPRS_ScoreTitleColor[0] , $SPRS_ScoreTitleColor[1], $SPRS_ScoreTitleColor[2] , round($SPRS,2)])
                ->with('DPRS', [$DPRS_Score, $DPRS_ScoreTitleColor[0] , $DPRS_ScoreTitleColor[1], $DPRS_ScoreTitleColor[2] , round($DPRS,2)]);
                // ->with('EIR', [$EIR_Score, $EIR_ScoreTitleColor[0] , $EIR_ScoreTitleColor[1], $EIR_ScoreTitleColor[2] , $EIR])
                // ->with('VRC4', [$VRC4_Score, $VRC4_ScoreTitleColor[0] , $VRC4_ScoreTitleColor[1], $VRC4_ScoreTitleColor[2] , $VRC4])
                // ->with('VRC6', [$VRC6_Score, $VRC6_ScoreTitleColor[0] , $VRC6_ScoreTitleColor[1], $VRC6_ScoreTitleColor[2] , $VRC6]);
            }
        }
        redirect()->back();
    }
    
    
    public function getPara($id = '', Request $request = null){

        $allocation_id = $id;// $request->input('patient_id');
        if($allocation_id == null || $allocation_id == ''){
            $allocation_id = $request->input('allocation_id');
        }

        $allocation = Allocation::where('auto_num', $allocation_id)->get();
        if($allocation->first()){            
            $patient_id = $allocation->first()->user_num;            
            $patient = Users::where('id', $patient_id)->get()->first();
            if($patient){
                $bmiData = $this->getBMI($patient->weight, $patient->user_height);          
                $step4Data =  getLevelBood($allocation_id, 4);
                $step6Data =  getLevelBood($allocation_id, 6);
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

                // Adrenergic                                                                                 
                $RR = getRR($allocation_id, 5);
                $MaxMin = getLongShortRR($RR);
                $EIR_Score = 0;$EIR = 0;
                if($MaxMin[1] != 0){
                    $EIR = $MaxMin[0] / $MaxMin[1];
                }
                if($EIR >= 1.2){
                    $EIR_Score = 1;
                }
                $EIR_ScoreTitleColor = getRiskAndTitleColor( $EIR_Score , 0.1, 1 , 0, 0 , 0 , 67 , 33, 0, 0, 0 );

                $VRC4_Score = 0;
                if( $VRC4 >= 1.25){
                    $VRC4_Score = 1;
                }
                $VRC4_ScoreTitleColor = getRiskAndTitleColor( $VRC4_Score , 0.1, 1 , 0, 0 , 0 , 67 , 33, 0, 0, 0 );

                $VRC6_Score = 0;
                if($VRC6 >= 1.13){
                    $VRC6_Score = 1;
                }
                $VRC6_ScoreTitleColor = getRiskAndTitleColor( $VRC6_Score , 0.1, 1 , 0, 0 , 0 , 67 , 33, 0, 0, 0 );

                $ParaScore = $EIR_Score + $VRC4_Score + $VRC6_Score;                
                $para = getRiskAndTitleColor($ParaScore, 1, 2, 3, 0, 0, 24, 26, 26, 24 , 0);

                return view('doctor.review.sub_para')
                ->with('allocation', $allocation->first())
                ->with('patient', $patient)
                ->with('bmi', $bmiData[0])->with('weight_status', $bmiData[1])->with('color', $bmiData[2])
                ->with('para', [$ParaScore, $para[0] , $para[1] , $para[2]])                                
                ->with('EIR', [$EIR_Score, $EIR_ScoreTitleColor[0] , $EIR_ScoreTitleColor[1], $EIR_ScoreTitleColor[2] , round($EIR,2)])
                ->with('VRC4', [$VRC4_Score, $VRC4_ScoreTitleColor[0] , $VRC4_ScoreTitleColor[1], $VRC4_ScoreTitleColor[2] , round($VRC4,2 )])
                ->with('VRC6', [$VRC6_Score, $VRC6_ScoreTitleColor[0] , $VRC6_ScoreTitleColor[1], $VRC6_ScoreTitleColor[2] , round($VRC6, 2)]);

            }
        }
        redirect()->back();
    }


     
    public function getCardiac($id = '', Request $request = null){

        $allocation_id = $id;// $request->input('patient_id');
        if($allocation_id == null || $allocation_id == ''){
            $allocation_id = $request->input('allocation_id');
        }
        $allocation = Allocation::where('auto_num', $allocation_id)->get();
        if($allocation->first()){            
            $patient_id = $allocation->first()->user_num;            
            $patient = Users::where('id', $patient_id)->get()->first();
            if($patient){

                $bmiData = $this->getBMI($patient->weight, $patient->user_height);

                $step3RRData = getRR($allocation_id, 3);                
                $step6RRData = getRR($allocation_id, 6);
                $step3Data =  getLevelBood($allocation_id, 3);
                $step4Data =  getLevelBood($allocation_id, 4);
                $step6Data =  getLevelBood($allocation_id, 6);       


                $AVG_RR  = $step3RRData[2];                 // Get Avg RR Value
                $AVG_RR_Score = getAvgRRScore($AVG_RR);            // Get Avg RR Score      
                $RR = getRiskAndTitleColor( $AVG_RR_Score , 0.1, 1 , 3, 0 , 0 , 33.3 , 33.3, 33.4, 0, 0 );

                
                $VRC4 = $step4Data[Config::get('constants.options.max_heart_rate')] / $step4Data[Config::get('constants.options.min_heart_rate')];
                $VRC6 = $step6Data[Config::get('constants.options.max_heart_rate')] / $step6Data[Config::get('constants.options.min_heart_rate')];
                $VRC4_Score = 0;
                if( $VRC4 > 1.25){
                    $VRC4_Score = 1;
                }
                $VRC4_Title_Color = getRiskAndTitleColor( $VRC4_Score , 0.1, 1 , 0, 0 , 0 , 50 , 50, 0, 0, 0 );

                $VRC6_Score = 0;
                if($VRC6 > 1.13){
                    $VRC6_Score = 1;
                }
                $VRC6_Title_Color = getRiskAndTitleColor( $VRC6_Score , 0.1, 1 , 0, 0 , 0 , 50 , 50, 0, 0, 0 );

                $SPRS = $step3Data[Config::get('constants.options.avg_systolic')] - $step6Data[Config::get('constants.options.avg_systolic')];
                $SPRS_Score = getSPRSScore($SPRS);
                $SPRS_Title_Color = getRiskAndTitleColor( $SPRS_Score , 1, 3 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );

                $DPRS =  $step3Data[Config::get('constants.options.avg_diastolic')] - $step6Data[Config::get('constants.options.avg_diastolic')];
                $DPRS_Score = getDPRSScore($DPRS);
                $DPRS_Title_Color = getRiskAndTitleColor( $DPRS_Score , 1, 3 , 4, 5 , 0 , 25 , 25, 25, 25, 0 );

                $step7Data =  getLevelBood($allocation_id, 7);
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


                return view('doctor.review.sub_cardiac')
                ->with('allocation', $allocation->first())
                ->with('patient', $patient)
                ->with('bmi', $bmiData[0])->with('weight_status', $bmiData[1])->with('color', $bmiData[2])
                ->with('card', [$CardScore, $card[0] , $card[1] , $card[2]])        
                ->with('RR', [$AVG_RR_Score, $RR[0] , $RR[1], $RR[2] , round($AVG_RR, 2)])
                ->with('VRC4', [$VRC4_Score, $VRC4_Title_Color[0] , $VRC4_Title_Color[1], $VRC4_Title_Color[2] , round($VRC4, 2)])
                ->with('VRC6', [$VRC6_Score, $VRC6_Title_Color[0] , $VRC6_Title_Color[1], $VRC6_Title_Color[2] , round($VRC6, 2)])
                ->with('SPRS', [$SPRS_Score, $SPRS_Title_Color[0] , $SPRS_Title_Color[1], $SPRS_Title_Color[2] , round($SPRS, 2)])
                ->with('DPRS', [$DPRS_Score, $DPRS_Title_Color[0] , $DPRS_Title_Color[1], $DPRS_Title_Color[2] , round($DPRS, 2)])
                ->with('SPRS7', [$SPRS7_Score, $SPRS7_Title_Color[0] , $SPRS7_Title_Color[1], $SPRS7_Title_Color[2] , round($SPRS7, 2)]);

            }
        }
        redirect()->back();
    }
    

    


}
