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

class ReportController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;      
    private $BASELINE = 3;
    private $VALSA = 4;
    private $DEEPBREADING = 5;
    private $STANDING = 6;
    private $HANDGRIP = 7;
    

    public function getTest(){
        //$data = $this->getOximeterRR(42,4);       
        //echo json_encode($data);
        $data  = array('patient_id'=>3, "weight"=>33);
        $res = CallAPI("POST", "https://prohealthdetect.com/phd/api/updateWeight", $data);
        echo json_encode($res);

    }

    public function getReview($id = '', Request $request = null){

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
                // get bmi values                
                $bmiData = $this->getBMI($patient->weight, $patient->user_height); // val, weight status, color, score
                $bmi = $bmiData[0];
                $weight_status = $bmiData[1];
                $color = $bmiData[2];
                                
                // get Type II Risk                
                $age_score = getAgeScore($patient->age); // Get Age Score
                $diabet_risk_score = $age_score;
                
                $bmi_score = $bmiData[3]; // Get BMI Score
                $diabet_risk_score += $bmi_score;

                
                $allocation_visit_form = AllocationVisitForm::where('id', $visit_form_id)->get()->first(); 
                $user_diabet = UserDiabet::where('id', $diabet_risk_id)->get()->first();

                $waist = $user_diabet->waist;
                $bpmeds = $user_diabet->bpmeds;
                $glucose = $user_diabet->glucose;
                $vegetable = $user_diabet->vegetable;
                $family = $user_diabet->family;
                                                
                if($bpmeds == 1){
                    $diabet_risk_score += 2;
                }
                if($glucose == 1){
                    $diabet_risk_score += 5;
                }
                                
                $activity = $allocation_visit_form->daily_activity;
                if($activity <= 4){
                    $diabet_risk_score +=2;
                }

                if($vegetable == 0){
                    $diabet_risk_score += 1;
                }
                
                if($family == 2){
                    $diabet_risk_score += 5;
                }else if($family == 1){
                    $diabet_risk_score += 3;
                }
                if($patient->sex == "Male"){
                    if($waist >= 37 && $waist < 40){
                        $diabet_risk_score += 3;
                    }else if($waist >= 40){
                        $diabet_risk_score += 4;
                    }
                }else{
                    if($waist >= 31 && $waist < 35){
                        $diabet_risk_score += 3;
                    }else if($waist >= 35){
                        $diabet_risk_score += 4;
                    }
                }
                
                $overall_blood = getRiskAndTitleColor($diabet_risk_score, 3, 8, 12, 20, 26,   12, 19, 15, 21 , 33);            
                $diabet_risk = $overall_blood[0];
                $diabet_risk_name = $overall_blood[1];
                $diabet_risk_color = $overall_blood[2];
            
                //Overall Blood Pressure                             
               $step3Data =  getLevelBood($allocation_id, $this->BASELINE);
               $step6Data =  getLevelBood($allocation_id, $this->STANDING);
               $step5Data =  getLevelBood($allocation_id, $this->DEEPBREADING);
               
               $SPRS = abs($step3Data[Config::get('constants.options.avg_systolic')] - $step6Data[Config::get('constants.options.avg_systolic')]);
               $DPRS = abs($step3Data[Config::get('constants.options.avg_diastolic')] - $step6Data[Config::get('constants.options.avg_diastolic')]);
       
               $overall_blood_score = $step3Data[Config::get('constants.options.score')] + $step6Data[ Config::get('constants.options.score') ];  
               
                $StandingResponseScore = getSPRS_DPRS_Score($SPRS, $DPRS); // Get SPRS, DPRS Score 
                $overall_blood_score += $StandingResponseScore[0];
                      

               $step4Data =  getLevelBoodValsa($allocation_id, $this->VALSA);       
               $overall_blood_score  +=  $step4Data[Config::get('constants.options.score')];

               $SPRV = ($step3Data[Config::get('constants.options.avg_systolic')] - $step4Data[ Config::get('constants.options.avg_systolic') ]);

               if( $SPRV > -20 && $SPRV <= -10){
                   $overall_blood_score = $overall_blood_score + 2;
               }else if($SPRV > -10 && $SPRV <= -5){
                   $overall_blood_score = $overall_blood_score + 3;
               }else if($SPRV > -5 && $SPRV != 0){
                   $overall_blood_score = $overall_blood_score + 4;
               }

                $step5RRData = $this->getOximeterRR($allocation_id, 5);                
                $VRC5 = 0;
                if( count($step5RRData[0])  > 0){
                    $MaxMin = getLongShortRR($step5RRData[0]); 
                    if($MaxMin[1] != 0){
                        $VRC5 = $MaxMin[0] / $MaxMin[1];
                    }
                } 
                $VRC5_Score = 0;
                if($VRC5 < 1.2){
                    $overall_blood_score  += 1;
                    $VRC5_Score = 1;                
                }
                               
                $VRC4 = 0;
                $step4RRData = $this->getOximeterRR($allocation_id, 4);
                if( count($step4RRData[0])  > 0){
                    $MaxMin = getLongShortRR($step4RRData[0]); 
                    if($MaxMin[1] != 0){
                        $VRC4 = $MaxMin[0] / $MaxMin[1];
                    }
                }  

               if($VRC4 < 1.25){
                   $overall_blood_score = $overall_blood_score + 1;
               }

               $VRC6 = 0;
                $step6RRData = $this->getOximeterRR($allocation_id, 6);
                if( count($step6RRData[0])  > 0){
                    $MaxMin = getLongShortRR($step6RRData[0]); 
                    if($MaxMin[1] != 0){
                        $VRC6 = $MaxMin[0] / $MaxMin[1];
                    }
                }
               if($VRC6 < 1.13){
                   $overall_blood_score = $overall_blood_score + 1;
               }               
               $overall_blood = getRiskAndTitleColor($overall_blood_score, 7, 15, 23, 30, 0, 23, 27, 27, 23 , 0);
               


               // ANS Dysfunction Rist                
               $HR = $step3Data[Config::get('constants.options.avg_heart_rate')]; // mean heard rate during step 3.
               $ANS_Score = getANSHeartScore($patient->sex, $patient->age, $HR);

               $step3OximeterData = 
               $SDNN = $this->getSDNN($allocation_id, 3);      // Get SDNN Value
               $SDNN_SCORE = getSDNNScore($patient->age, $SDNN);    // Get SDNN Score 
               $ANS_Score  +=  $SDNN_SCORE;

               $RMSSD = $this->getRMSSD($allocation_id, 3);      // Get RMSSD Value
               $RMSSD_SCORE = getRMSSDScore($patient->age, $RMSSD);  // Get RMSSD Score  
               $ANS_Score  +=  $RMSSD_SCORE;
                             
                $step3RRData = getRR($allocation_id, 3);    
                $AVG_RR  = $step3RRData[2];                 // Get Avg RR Value
                $AVG_RR_Score = getAvgRRScore($AVG_RR);            // Get Avg RR Score 
                $ANS_Score += $AVG_RR_Score;
               
                $PERCENT_MORE_THAN_50 = $step3RRData[3];                            // Get Vale
                $PERCENT_MORE_THAN_50_Score = get50Score($PERCENT_MORE_THAN_50);    // Get Score 
                $ANS_Score += $PERCENT_MORE_THAN_50_Score;
                             
                $AVG_OXYGEN = $step3RRData[1];             
                if($AVG_OXYGEN < 94 ){
                    $ANS_Score += 1;
                }
                $ans_dysfunction = getRiskAndTitleColor($ANS_Score, 5, 9, 14, 18, 0, 28, 22, 28, 22 , 0);

                // Skin Report 
                $GSR = $this->getGSR($allocation_id, 3);
                //$Female_Hand_Score = 0; $Female_Feet_Score = 0;
                $Hand_Score = 0; $Feet_Score = 0;
                if($patient->sex == "Male"){
                    $Hand_Score = getMaleHandScore($patient->age, $GSR[0]);
                    $Feet_Score = getMaleFeetScore($patient->age, $GSR[1]);
                }else{
                    $Hand_Score = getFemaleHandScore($patient->age, $GSR[0]);
                    $Feet_Score = getFemaleFeetScore($patient->age, $GSR[1]);     
                }
                $SkinTitleColor = getSkinTitleColor($Hand_Score + $Feet_Score, "overall");

                // Adrenergic 
                $AVG_Systolic_Baseline = $step3Data[Config::get('constants.options.avg_systolic')];
                $AVG_Diastolic_Baseline = $step3Data[Config::get('constants.options.avg_diastolic')];                
                $AVG_Systolic_Standing = $step6Data[Config::get('constants.options.avg_systolic')];
                $AVG_Diastolic_Standing = $step6Data[Config::get('constants.options.avg_diastolic')];                

                $BaselineSysScore = getBaselineFromSys($AVG_Systolic_Baseline);
                $BaselineDiaScore = getBaselineFromDia($AVG_Diastolic_Baseline);
                $StandingSysScore = getStandingFromSys($AVG_Systolic_Standing);
                $StandingDiaScore = getStandingFromDia($AVG_Diastolic_Standing);   

                $SPRV_Score = getValsalvaScore($SPRV);

                $SPRS = $step3Data[Config::get('constants.options.avg_systolic')] - $step6Data[Config::get('constants.options.avg_systolic')];
                $SPRS_Score = getSPRSScore($SPRS);
                $DPRS =  $step3Data[Config::get('constants.options.avg_diastolic')] - $step6Data[Config::get('constants.options.avg_diastolic')];
                $DPRS_Score = getDPRSScore($DPRS);
                
                $AdrenergicScore = $BaselineSysScore + $BaselineDiaScore + $StandingSysScore + $StandingDiaScore + $SPRV_Score + $SPRS_Score + $DPRS_Score ; //+ $EIR_Score + $VRC4_Score + $VRC6_Score
                $adrenergic = getRiskAndTitleColor($AdrenergicScore, 9, 19, 29, 38, 0, 24, 26, 26, 24 , 0);                

                $AVG_Systolic_Baseline = $step3Data[Config::get('constants.options.avg_systolic')];
                $AVG_Diastolic_Baseline = $step3Data[Config::get('constants.options.avg_diastolic')];                
                $AVG_Systolic_Standing = $step6Data[Config::get('constants.options.avg_systolic')];
                $AVG_Diastolic_Standing = $step6Data[Config::get('constants.options.avg_diastolic')];                

                $BaselineSysScore = getBaselineFromSys($AVG_Systolic_Baseline);
                $BaselineDiaScore = getBaselineFromDia($AVG_Diastolic_Baseline);
                $StandingSysScore = getStandingFromSys($AVG_Systolic_Standing);
                $StandingDiaScore = getStandingFromDia($AVG_Diastolic_Standing);                
                $SPRV_Score = getValsalvaScore($SPRV);
                $SPRS = $step3Data[Config::get('constants.options.avg_systolic')] - $step6Data[Config::get('constants.options.avg_systolic')];
                $SPRS_Score = getSPRSScore($SPRS);
                $DPRS =  $step3Data[Config::get('constants.options.avg_diastolic')] - $step6Data[Config::get('constants.options.avg_diastolic')];
                $DPRS_Score = getDPRSScore($DPRS);
                $AdrenergicScore = $BaselineSysScore + $BaselineDiaScore + $StandingSysScore + $StandingDiaScore + $SPRV_Score + $SPRS_Score + $DPRS_Score ;
                $adrenergic = getRiskAndTitleColor($AdrenergicScore, 7, 15, 23, 30, 0, 24, 26, 26, 24 , 0);

                
                // Para 
                $step5RRData = $this->getOximeterRR($allocation_id, 5);                
                //$RR = getRR($allocation_id, 5);
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


                $VRC4 = 0;
                $step4RRData = $this->getOximeterRR($allocation_id, 4);
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

                $VRC6 = 0;
                $step6RRData = $this->getOximeterRR($allocation_id, 6);
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
                $ParaScore = $EIR_Score + $VRC4_Score + $VRC6_Score;
                $para = getParaTitleColor($ParaScore, "overall");

                
                // Card
                //$step3RRData = getRR($allocation_id, 3);    
                //$AVG_RR  = $step3RRData[2];                 // Get Avg RR Value
                $AVG_RR_Score = getAvgRRScore($AVG_RR);            // Get Avg RR Score               
                // $VRC4 = $step4Data[Config::get('constants.options.max_heart_rate')] / $step4Data[Config::get('constants.options.min_heart_rate')];
                // $VRC6 = $step6Data[Config::get('constants.options.max_heart_rate')] / $step6Data[Config::get('constants.options.min_heart_rate')];
                $step7Data =  getLevelBood($allocation_id, $this->HANDGRIP);
                $SPRS7 = $step3Data[Config::get('constants.options.avg_systolic')] - $step7Data[Config::get('constants.options.avg_systolic')];
                $SPRS7_Score = 0;                
                if($SPRS7 < 11){
                    $SPRS7_Score += 3;
                }else if($SPRS7 >= 11 &&  $SPRS7 < 16){
                    $SPRS7_Score += 1;
                }

                $CardScore = $AVG_RR_Score + $VRC4_Score + $VRC6_Score + $SPRS_Score + $DPRS_Score + $SPRS7_Score;
                $card = getRiskAndTitleColor($CardScore, 4, 9, 13, 18, 0, 22, 28, 22, 28 , 0);
                              
                
                return view('doctor.review.gauge')
                ->with('allocation', $allocation->first())
                ->with('patient', $patient)
                ->with('bmi', $bmi)
                ->with('weight_status', $weight_status)                
                ->with('color', $color)                
                ->with('diabet_risk_score', $diabet_risk_score)
                ->with('diabet_risk_percent', $diabet_risk)
                ->with('diabet_risk_name', $diabet_risk_name)
                ->with('diabet_risk_color', $diabet_risk_color)
                ->with('overall_blood_risk_score', $overall_blood_score)
                ->with('overall_blood_risk_percent', $overall_blood[0])
                ->with('overall_blood_risk_name', $overall_blood[1])
                ->with('overall_blood_risk_color', $overall_blood[2])
                ->with('ans_dysfunction_risk_score', $ANS_Score)
                ->with('ans_dysfunction_risk_percent', $ans_dysfunction[0])
                ->with('ans_dysfunction_risk_name', $ans_dysfunction[1])
                ->with('ans_dysfunction_risk_color', $ans_dysfunction[2])
                ->with('skin', [$Hand_Score + $Feet_Score, $SkinTitleColor[0] , $SkinTitleColor[1] , $SkinTitleColor[2]])
                ->with('adrenergic', [$AdrenergicScore, $adrenergic[0] , $adrenergic[1] , $adrenergic[2]])
                ->with('para', [$ParaScore, $para[0] , $para[1] , $para[2]])
                ->with('card', [$CardScore, $card[0] , $card[1] , $card[2]]);
                
            }                
        }
        redirect()->back();       
    }


 
    




}
