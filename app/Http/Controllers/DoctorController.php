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
use App\Message;
use App\VisitPurpose;
use App\AllocationVisitForm;
use App\UserDiabet;
use App\Blood;
use Config;

use Session;
use DateTime;


class DoctorController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $BASELINE = 3;
    private $VALSA = 4;
    private $DEEPBREADING = 5;
    private $STANDING = 6;
    private $HANDGRIP = 7;

    public function getDashboard()
    {
       // get patient
       $usertype = UserType::where('user_type_name',"Patient")->get();
       $patients = Users::where('user_type_id', $usertype->first()->auto_num)->where('company_id', Session::get('company_id'))->get();

       // get overal data.
       $all  = Allocation::where('company_id', Session::get('company_id'))->get();
       $data['total_tests']  = $all->count();
       $data['success_tests'] = Allocation::where('is_allocated','0')->where('company_id', Session::get('company_id'))->get()->count();
       $data['failed_tests'] = Allocation::where('is_allocated', '2')->where('company_id', Session::get('company_id'))->get()->count();
       
       if($all->first()){
           $sdt = new DateTime($all->first()->created_at);
           $edt = new DateTime($all->last()->created_at);
           $data['start_date'] = $sdt->format('Y-m-d');
           $data['end_date'] = $edt->format('Y-m-d');
       }else{
           $data['start_date'] = date('Y-m-d');
           $data['end_date'] = date('Y-m-d');
       }
       // get error data
      
       $allocation = Allocation::where('company_id', Session::get('company_id'))->get();
       foreach($allocation as $allo){
           $admin = Users::where('id', $allo->administer_num)->get();
           if($admin->first()){
               $allo->administer_num = $admin->first()->first_name;
           }
       }

       return view('doctor.dashboard')
            ->with('allocation', $allocation)
            ->with('patients', $patients)
            ->with('data', $data);
    }

    public function getTestland(){
        if (Session::get('user_id') == null) {            
            return redirect('login');
        }
        return view('doctor.testland');
    }        

    public function getPrestep1($userId = '', Request $request){

        if($request->has('id')){
            $id = $request->input('id');
            $user_type = UserType::where('user_type_name','Patient')->get();
            $patients = Users::where('user_type_id',$user_type->first()->auto_num)            
                ->where('company_id', Session::get('company_id'))
                ->orderBy("first_name")
                ->get();
            
        }else{
            $id = "-1";
            $user_type = UserType::where('user_type_name','Patient')->get();
            $patients = Users::where('user_type_id',$user_type->first()->auto_num)
                ->where('company_id', Session::get('company_id'))
                ->orderBy("first_name")
                ->get();
        }

        return view('doctor.prestep.prestep1')
            ->with('patients', $patients)
            ->with('id', $id);
    }


    public function getPrestep2($id = '' , Request $request = null){
        $patient_id = $request->input('patient_id');
        $patient = Users::where('id', $patient_id)->get()->first();

        if($patient){

            $user_diabet = UserDiabet::where('user_id', $patient_id)->orderBy('id', 'DESC')->get();
            
            return view('doctor.prestep.prestep2')
            ->with('patient', $patient)
            ->with('user_diabet', $user_diabet);            
        }else{
            return redirect()->back();
        }                
    }

    public function getPrestep3($id = '' , Request $request = null){

        $user_type = $request->input('user_type');
        $patient_id = $request->input('patient_id');

        // check if there is uncompleted test.
        $tester_id = Session::get("user_id");
        $check = Allocation::where('user_num', $patient_id)
        ->where('administer_num', $tester_id)
        ->where('is_allocated', '1') // 1: allocated status
        ->get();
        
        //if there is uncompleted one, abort it automatically.
        if($check->first()){
            $status = 2; // 2: abort the test.
            DB::table('tbl_allocation')
            ->where('auto_num', $check->first()->auto_num)
            ->update(['is_allocated' => $status]);    
        }
            

        // save pre test 2 step ' values to user_diabet table
        $data = $request->all();        
        $data['user_id'] = $patient_id;
        $response = UserDiabet::create($data);

        
        $patient = Users::where('id', $patient_id)->get()->first();
        $symptoms = VisitPurpose::where('type', 'Symptoms')->get();
        $treatment = VisitPurpose::where('type', 'Treatment')->get();
        $disease = VisitPurpose::where('type', 'Disease')->get();

        $tester_id = Session::get("user_id");

        $diabet_risk_id = UserDiabet::where('user_id', $patient_id)->orderBy('id', 'DESC')->first()->id;

        return view('doctor.prestep.prestep3')
        ->with('patient', $patient)
        ->with('symptoms', $symptoms)
        ->with('treatment', $treatment)
        ->with('disease', $disease)
        ->with('user_type', $user_type)
        ->with('tester_id', $tester_id)
        ->with('diabet_risk_id', $diabet_risk_id);
    }


    public function getPrestep4($id = '' , Request $request = null){
        
        $patient_id = $request->input('patient_id');

        if (isset($_POST['next'])) {
            $visit_step = $request->input('visit_step');
            $visit_purpose = $request->input('visit_step');            
           
            $patient = Users::where('id', $patient_id)->get()->first();
            
            return view('doctor.prestep.prestep3')
                ->with('user_type', 'exist')
                ->with('patient', $patient);
        }else{
            $patient = Users::where('id', $patient_id)->get()->first();
            return view('doctor.prestep.prestep2')->with('patient', $patient);
        }       
    }

    
    public function getPasttest(){
        $user_type = UserType::where('user_type_name','Patient')->get();
        $patients = Users::where('user_type_id',$user_type->first()->auto_num)
            ->join('tbl_allocation', 'tbl_user.id', '=', 'tbl_allocation.user_num')
            ->where('is_allocated', '0') // 0  mean completed status.
            ->where('tbl_allocation.company_id', Session::get('company_id'))
            ->groupBy('id')            
            ->orderBy("first_name")
            ->get();
        return view('doctor.past.patientlists')
            ->with('patients', $patients);            
    }
            
    public function getTestlists($id = '' , Request $request = null){
        
        $patient_id = $request->input('patient_id');

        $patient = Users::where('id', $patient_id)->get()->first();

        $allocations = Allocation::where('user_num', $patient_id)
            ->where('is_allocated', '0')
            ->get();

        return view('doctor.past.testlists')
            ->with('patient', $patient)
            ->with('allocations', $allocations);
    }
    

    public function getEditDiabetForm($id = '', Request $request = null){
        $user_type = $request->input('user_type');
        $patient_id = $request->input('patient_id');
        $allocation_id = $request->input('allocation_id');
        $tester_id = Session::get("user_id");
        
        $patient = Users::where('id', $patient_id)->get()->first();
        $diabet_risk_id = Allocation::where('auto_num', $allocation_id)->get()->first()->diabet_risk_id;
        $diabet_form =UserDiabet::where('id', $diabet_risk_id)->get();

        if($diabet_form->first()){              
            return view('doctor.past.prestep2')
            ->with('patient', $patient)            
            ->with('user_type', $user_type)
            ->with('tester_id', $tester_id)
            ->with('user_diabet', $diabet_form)
            ->with('allocation_id', $allocation_id);                        
        }else{
            return redirect()->back();
        }   
    }
        
    public function getEditvisitform($id = '' , Request $request = null){
        $user_type = $request->input('user_type');
        $patient_id = $request->input('patient_id');
        $allocation_id = $request->input('allocation_id');

        
        // check if there is uncompleted test.
        $tester_id = Session::get("user_id");

        DB::table('tbl_user_diabet')
            ->where('user_id', $patient_id)
            ->update(['waist' => $request->input('waist')
            ,'bpmeds' => $request->input('bpmeds')
            ,'glucose' => $request->input('glucose')
            ,'vegetable' => $request->input('vegetable')            
            ,'family' => $request->input('family') ]);
        

        $visit_form_id = Allocation::where('auto_num', $allocation_id)->get()->first()->visit_form_id;
        
        $visit_form = AllocationVisitForm::where('id', $visit_form_id)->get();
                
        
        $patient = Users::where('id', $patient_id)->get()->first();
        $symptoms = VisitPurpose::where('type', 'Symptoms')->get();
        $treatment = VisitPurpose::where('type', 'Treatment')->get();
        $disease = VisitPurpose::where('type', 'Disease')->get();
        $tester_id = Session::get("user_id");
        
        if($visit_form->first()){                    
            return view('doctor.past.prestep3')
            ->with('patient', $patient)
            ->with('symptoms', $symptoms)
            ->with('treatment', $treatment)
            ->with('disease', $disease)
            ->with('user_type', $user_type)
            ->with('tester_id', $tester_id)
            ->with('visit_form', $visit_form->first())
            ->with('allocation_id', $allocation_id);
                        
        }else{
            return redirect()->back();
        }        
    }


    public function getSteps( $id = '' , Request $request = null ){
        
        $patient_id = $request->input('pid');
        $visit_form_id = $request->input('visit_form_id');
        $diabet_risk_id = $request->input('diabet_risk_id');        
        $allocation = Allocation::where('administer_num', Session::get('user_id'))
        ->where('user_num', $patient_id)
        ->where('is_allocated','1')->get(); // for saving old session.
        $user_type = UserType::where('user_type_name','Patient')->get();
        $patients = Users::where('user_type_id',$user_type->first()->auto_num)->where('company_id', Session::get('company_id'))->get();
        $devices = Device::where('company_id', Session::get('company_id'))->get();
        $patient = Users::where('id', $patient_id)->get();

        $gsr = false;
        $visit_form = AllocationVisitForm::where('id', $visit_form_id)->get();
        if($visit_form->first()){
            $treatment = $visit_form->first()->treatment;
            if (strpos($treatment, '51') !== false) {
                $gsr = true;
            }
            
        }

        if($patient->first()){
            return view('doctor.test.steps')
            ->with('patients', $patients)
            ->with('patient', $patient->first())
            ->with('devices', $devices)
            ->with('patient_id', $patient_id)
            ->with('visit_form_id', $visit_form_id)
            ->with('allocation', $allocation)
            ->with('gsr', $gsr)
            ->with('diabet_risk_id', $diabet_risk_id);

        }else{
            return redirect()->back();
        }
    }

    public function getLevelBood($allocation_id, $step){
        
       // $allocation_id = 139;
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
                $weight = $patient->weight;
                $height = $patient->user_height;
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

                // get Type II Risk
                $diabet_risk_score = 0;
                $age = $patient->age;
                if($age >=  45  && $age <= 54){
                    $diabet_risk_score = 2;
                }else if($age >=  55  && $age <= 64){
                    $diabet_risk_score = 3;
                }else if($age > 64){
                    $diabet_risk_score = 4;
                }

                if($bmi >= 25 && $bmi <= 30){
                    $diabet_risk_score = $diabet_risk_score + 1;
                }else if($bmi > 30){
                    $diabet_risk_score = $diabet_risk_score + 3;
                }

                $allocation_visit_form = AllocationVisitForm::where('id', $visit_form_id)->get()->first();
                $user_diabet = UserDiabet::where('id', $diabet_risk_id)->get()->first();
                $waist = $user_diabet->waist;
                $bpmeds = $user_diabet->bpmeds;
                $glucose = $user_diabet->glucose;
                $vegetable = $user_diabet->vegetable;
                $family = $user_diabet->family;
                                                
                if($bpmeds == 1){
                    $diabet_risk_score = $diabet_risk_score + 2;
                }
                if($glucose == 1){
                    $diabet_risk_score = $diabet_risk_score + 5;
                }
                                
                $activity = $allocation_visit_form->daily_activity;
                if($activity <= 4){
                    $diabet_risk_score = $diabet_risk_score + 2;
                }
                if($vegetable == 0){
                    $diabet_risk_score + $diabet_risk_score + 1;
                }
                if($family == 2){
                    $diabet_risk_score = $diabet_risk_score + 5;
                }else if($family == 1){
                    $diabet_risk_score = $diabet_risk_score + 3;
                }
                if($patient->sex == "Male"){
                    if($waist >= 94 && $waist < 102){
                        $diabet_risk_score = $diabet_risk_score + 3;
                    }else if($waist >= 102){
                        $diabet_risk_score = $diabet_risk_score + 4;
                    }
                }else{
                    if($waist >= 80 && $waist < 88){
                        $diabet_risk_score = $diabet_risk_score + 3;
                    }else if($waist >= 88){
                        $diabet_risk_score = $diabet_risk_score + 4;
                    }
                }
                
                $overall_blood = $this->getRiskAndTitleColor($diabet_risk_score, 3, 8, 12, 20, 26,   12, 19, 15, 21 , 33);            
                $diabet_risk = $overall_blood[0];
                $diabet_risk_name = $overall_blood[1];
                $diabet_risk_color = $overall_blood[2];
            
                //Overall Blood Pressure                
               $step3Data =  $this->getLevelBood($allocation_id, $this->BASELINE);
               $step6Data =  $this->getLevelBood($allocation_id, $this->STANDING);

               $SPRS = abs($step3Data[Config::get('constants.options.avg_systolic')] - $step6Data[Config::get('constants.options.avg_systolic')]);
               $DPRS = abs($step3Data[Config::get('constants.options.avg_diastolic')] - $step6Data[Config::get('constants.options.avg_diastolic')]);
       
               $overall_blood_score = $step3Data[Config::get('constants.options.score')] + $step6Data[ Config::get('constants.options.score') ];

               if($SPRS >= 10 && $SPRS < 20){
                   $overall_blood_score = $overall_blood_score + 2;
               }else if($SPRS >= 20 && $SPRS < 30){
                   $overall_blood_score = $overall_blood_score + 3;
               }else if($SPRS >= 30){
                   $overall_blood_score = $overall_blood_score + 4;
               }
               
               if($DPRS >= 5 && $DPRS < 10){
                   $overall_blood_score = $overall_blood_score + 2;
               }else if($DPRS >= 10 && $DPRS < 20){
                   $overall_blood_score = $overall_blood_score + 3;
               }else if($DPRS >= 20){
                   $overall_blood_score = $overall_blood_score + 4;
               }
       
               $step4Data =  $this->getLevelBood($allocation_id, $this->VALSA);
               $overall_blood_score = $overall_blood_score + $step4Data[Config::get('constants.options.score')];

               $SPRV = ($step3Data[Config::get('constants.options.avg_systolic')] - $step4Data[ Config::get('constants.options.avg_systolic') ]);
               if( $SPRV > -20 && $SPRV <= -10){
                   $overall_blood_score = $overall_blood_score + 2;
               }else if($SPRV > -10 && $SPRV <= -5){
                   $overall_blood_score = $overall_blood_score + 3;
               }else if($SPRV > -5 && $SPRV != 0){
                   $overall_blood_score = $overall_blood_score + 4;
               }
               
               if($step4Data[Config::get('constants.options.min_heart_rate')] != 0){
                   $VRC4 = $step4Data[Config::get('constants.options.max_heart_rate')] / $step4Data[Config::get('constants.options.min_heart_rate')];
               }else{
                   $VRC4 = 0;
               }                            
               if($VRC4 > 1.25){
                   $overall_blood_score = $overall_blood_score + 1;
               }
               if( $step6Data[Config::get('constants.options.min_heart_rate')] != 0){
                   $VRC6 = $step6Data[Config::get('constants.options.max_heart_rate')] / $step6Data[Config::get('constants.options.min_heart_rate')];
               }else{
                   $VRC6 = 0;
               }        
               if($VRC6 > 1.13){
                   $overall_blood_score = $overall_blood_score + 1;
               }               
               $overall_blood_score += 10;
               $overall_blood = $this->getRiskAndTitleColor($overall_blood_score, 7, 15, 23, 30, 0, 23, 27, 27, 23 , 0);
               

               // ANS Dysfunction Rist 
               $ANS_Score = 0;
               $HR = $step3Data[Config::get('constants.options.avg_heart_rate')]; // mean heard rate during step 3.
               if($patient->sex == "Male"){
                   if($age >= 18 && $age <= 25){
                        if($HR > 49 && $HR <=55){

                        }else if($HR > 55 && $HR <= 61){

                        }else if($HR > 61 && $HR <= 65){
                            $ANS_Score += 1;
                        }else if($HR > 65 && $HR <=69){
                            $ANS_Score += 2;
                        }else if($HR > 69 && $HR <= 73){
                            $ANS_Score += 3;
                        }else if($HR > 73 && $HR <= 81){
                            $ANS_Score += 4;
                        }else if($HR >= 82){
                            $ANS_Score += 5;
                        }                   
                   }else if($age >= 26 && $age <= 35){
                        if($HR > 49 && $HR <=54){

                        }else if($HR > 54 && $HR <= 61){

                        }else if($HR > 61 && $HR <= 65){
                            $ANS_Score += 1;
                        }else if($HR > 65 && $HR <= 70){
                            $ANS_Score += 2;
                        }else if($HR > 70 && $HR <= 74){
                            $ANS_Score += 3;
                        }else if($HR > 74 && $HR <= 81){
                            $ANS_Score += 4;
                        }else if($HR >= 82){
                            $ANS_Score += 5;
                        }    
                   }else if($age >= 36 && $age <= 45){
                        if($HR > 50 && $HR <= 56){

                        }else if($HR > 56 && $HR <= 62){

                        }else if($HR > 62 && $HR <= 66){
                            $ANS_Score += 1;
                        }else if($HR > 66 && $HR <= 70){
                            $ANS_Score += 2;
                        }else if($HR > 70 && $HR <= 75){
                            $ANS_Score += 3;
                        }else if($HR > 75 && $HR <= 82){
                            $ANS_Score += 4;
                        }else if($HR > 82){
                            $ANS_Score += 5;
                        }  
                   }else if($age >= 46 && $age <= 55){
                        if($HR > 50 && $HR <= 57){
                        }else if($HR > 57 && $HR <= 63){
                        }else if($HR > 63 && $HR <= 67){
                            $ANS_Score += 1;
                        }else if($HR > 67 && $HR <= 71){
                            $ANS_Score += 2;
                        }else if($HR > 71 && $HR <= 76){
                            $ANS_Score += 3;
                        }else if($HR > 76 && $HR <= 83){
                            $ANS_Score += 4;
                        }else if($HR > 83){
                            $ANS_Score += 5;
                        }  
                   }else if($age >= 56 && $age <= 65){
                        if($HR > 51 && $HR <= 56){
                        }else if($HR > 56 && $HR <= 61){
                        }else if($HR > 61 && $HR <= 67){
                            $ANS_Score += 1;
                        }else if($HR > 67 && $HR <= 71){
                            $ANS_Score += 2;
                        }else if($HR > 71 && $HR <= 75){
                            $ANS_Score += 3;
                        }else if($HR > 75 && $HR <= 81){
                            $ANS_Score += 4;
                        }else if($HR > 81){
                            $ANS_Score += 5;
                        }  
                   }else if($age > 65){
                        if($HR > 50 && $HR <= 55){
                        }else if($HR > 55 && $HR <= 61){
                        }else if($HR > 61 && $HR <= 65){
                            $ANS_Score += 1;
                        }else if($HR > 65 && $HR <= 69){
                            $ANS_Score += 2;
                        }else if($HR > 69 && $HR <= 73){
                            $ANS_Score += 3;
                        }else if($HR > 73 && $HR <= 79){
                            $ANS_Score += 4;
                        }else if($HR > 79){
                            $ANS_Score += 5;
                        }  
                   }
               }else{

                    if($age >= 18 && $age <= 25){
                            if($HR > 54 && $HR <= 60){
                            }else if($HR > 60 && $HR <= 65){
                            }else if($HR > 65 && $HR <= 69){
                                $ANS_Score += 1;
                            }else if($HR > 69 && $HR <=73){
                                $ANS_Score += 2;
                            }else if($HR > 73 && $HR <= 78){
                                $ANS_Score += 3;
                            }else if($HR > 78 && $HR <= 84){
                                $ANS_Score += 4;
                            }else if($HR > 84){
                                $ANS_Score += 5;
                            }                   
                    }else if($age >= 26 && $age <= 35){
                            if($HR > 54 && $HR <= 59){
                            }else if($HR > 59 && $HR <= 64){
                            }else if($HR > 64 && $HR <= 68){
                                $ANS_Score += 1;
                            }else if($HR > 68 && $HR <= 72){
                                $ANS_Score += 2;
                            }else if($HR > 72 && $HR <= 76){
                                $ANS_Score += 3;
                            }else if($HR > 76 && $HR <= 82){
                                $ANS_Score += 4;
                            }else if($HR > 82){
                                $ANS_Score += 5;
                            }    
                    }else if($age >= 36 && $age <= 45){
                            if($HR > 54 && $HR <= 59){

                            }else if($HR > 59 && $HR <= 64){

                            }else if($HR > 64 && $HR <= 69){
                                $ANS_Score += 1;
                            }else if($HR > 69 && $HR <= 73){
                                $ANS_Score += 2;
                            }else if($HR > 73 && $HR <= 78){
                                $ANS_Score += 3;
                            }else if($HR > 78 && $HR <= 84){
                                $ANS_Score += 4;
                            }else if($HR > 84){
                                $ANS_Score += 5;
                            }  
                    }else if($age >= 46 && $age <= 55){
                            if($HR > 54 && $HR <= 60){
                            }else if($HR > 60 && $HR <= 65){
                            }else if($HR > 65 && $HR <= 69){
                                $ANS_Score += 1;
                            }else if($HR > 69 && $HR <= 73){
                                $ANS_Score += 2;
                            }else if($HR > 73 && $HR <= 77){
                                $ANS_Score += 3;
                            }else if($HR > 77 && $HR <= 83){
                                $ANS_Score += 4;
                            }else if($HR > 83){
                                $ANS_Score += 5;
                            }  
                    }else if($age >= 56 && $age <= 65){
                            if($HR > 54 && $HR <= 59){
                            }else if($HR > 59 && $HR <= 64){
                            }else if($HR > 64 && $HR <= 68){
                                $ANS_Score += 1;
                            }else if($HR > 68 && $HR <= 73){
                                $ANS_Score += 2;
                            }else if($HR > 73 && $HR <= 77){
                                $ANS_Score += 3;
                            }else if($HR > 77 && $HR <= 83){
                                $ANS_Score += 4;
                            }else if($HR > 83){
                                $ANS_Score += 5;
                            }  
                    }else if($age > 65){
                            if($HR > 54 && $HR <= 59){
                            }else if($HR > 59 && $HR <= 64){
                            }else if($HR > 64 && $HR <= 68){
                                $ANS_Score += 1;
                            }else if($HR > 68 && $HR <= 72){
                                $ANS_Score += 2;
                            }else if($HR > 72 && $HR <= 76){
                                $ANS_Score += 3;
                            }else if($HR > 76 && $HR <= 84){
                                $ANS_Score += 4;
                            }else if($HR > 84){
                                $ANS_Score += 5;
                            }  
                    }                    
               }




                return view('doctor.review.gauge')
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
                ->with('overall_blood_risk_color', $overall_blood[2]);
                
            }                
        }    

        redirect()->back();                
    }


    public function getRiskAndTitleColor($measure, $val1, $val2 , $val3 , $val4, $val5 = 0, $per1, $per2, $per3, $per4, $per5){

        if($measure <= $val1){
            $risk = ($per1 / $val1) * $measure; 
            $risk_title = "Very Low";            
            $risk_color = "green-color";
        }
        if($measure > $val1 && $measure <= $val2){
            $risk = $per1 + ($per2 / ($val2 - $val1) ) * ($measure - $val1);
            $risk_title = "Low";
            if($val5 == 0){
                $risk_color = "yellow-color";
            }else{
                $risk_color = "green-color";
            }
            
        }
        if($measure > $val2 && $measure <= $val3){
            $risk = $per1 + $per2 + ($per3 / ($val3 - $val2)) * ($measure - $val2);
            $risk_title = "Moderate";
            if($val5 == 0){
                $risk_color = "orange-color";
            }else{
                $risk_color = "yellow-color";
            }
            

        }
        if($measure > $val3 && $measure <= $val4){
            $risk = $per1 + $per2 + $per3 + ( $per4 / ($val4 - $val3) ) * ($measure - $val3);
            $risk_title = "High";
            if($val5 == 0){
                $risk_color = "red-color";
            }else{
                $risk_color = "orange-color";
            }            
        }

        if($val5 != 0 && $per5 != 0){
            if($measure > $val4 && $measure <= $val5){
                $risk = $per1 + $per2 + $per3 + $per4 + ( $per5 / ($val5-$val4)) * ($measure - $val4);
                $risk_title = "Very High";
                $risk_color = "red-color";
            }
        }    
        return [$risk , $risk_title, $risk_color];

    }


}
