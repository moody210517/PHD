<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Send;
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
use App\Product;
use App\VisitPurpose;
use App\UserDiabet;

use Goutte\Client;
use Goutte;

use Session;
use DateTime;


class OfficeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getDashboard()
    {
        $allocation = Allocation::where('administer_num', Session::get('user_id'))->where('is_allocated','1')->get();
        return view('admin.usermanagement.dashboard')
        ->with('allocation', $allocation);
    }
    // -------------------------------------------- Patient part managment ----------------------------------------
    public function getPatients($id = '' , Request $request = null){
        
        $user = UserType::where('user_type_name', "Patient")->get();
        $users = Users::where('company_id', Session::get('company_id'))
        ->where('id', '!=', Session::get('user_id'))
        ->where('user_type_id', $user->first()->auto_num)
        ->orderBy('id', 'DESC')
        ->get();        

        foreach($users as $user){
            $company = Company::where('auto_num', $user->company_id)->get();  
            if($company->first()) {
                $user->company_id = $company->first()->company_name;
            }else{
                $user->company_id = "Admin";
            }
            $userType = UserType::where('auto_num', $user->user_type_id)->get();
            if($userType->first()){
                $user->user_type_id = $userType->first()->user_type_name;
            }else{
                $user->user_type_id = "Unknown";
            }            
        }
        return view('officeManager.patient.users')
        ->with('users', $users)
        ->with('page', 'patient')
        ->with('type', $id);
    }

    public function getAddpatient2($id = 'other' , Request $request = null){
        $error_msg = "";
        if($request->has('first_name')){ 
            $this->getAddpatient('other' , $request);
        }
        $company = Company::where('history',1)->get();            
        $usertype = UserType::where('user_type_name',"Patient")->get();

        $country = Country::all();
        $state = State::where('country_id', '1')->get();
        $city = City::where('state_id', '1')->orderBy("city_name")->get();
        
        return view('officeManager.patient.addUser')
        ->with('company', $company)
        ->with('country', $country)
        ->with('state', $state)
        ->with('city', $city)
        ->with('page', 'patient')       
        ->with('logintype', Session::get('user_type'))
        ->with('usertype', $usertype)
        ->with('from', "testland")
        ->with('error_msg', $error_msg);

        
    }

    public function getAddpatient($id = '' , Request $request = null){    


        
        $error_msg = "";
        if($request->has('first_name')){ 
            //$pwd = $request->input('user_password'); 
            //$cpwd = $request->input('confirmPassword');

            $home = $request->input('home_num'); 
            $mobile = $request->input('mobile_num');    //preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $home) &&        
            if( preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $mobile)){

                $check = Users::where('first_name', $request->input('first_name'))
                    ->where('last_name', $request->input('last_name'))
                    ->where('last_name', $request->input('last_name'))
                    ->where('date_of_birth', $request->input('date_of_birth'))
                    ->get();
                    
                if(!$check->first()){  

                    $user = new Users();                
                    $user->first_name = $request->input('first_name'); 
                    $user->last_name = $request->input('last_name'); 
                    $user->email_address = $request->input('email_address'); 
                    //$user->user_password = $request->input('user_password'); 
                    //$user->office_num = $request->input('office_num'); 

                    $user->home_num = $request->input('home_num'); 
                    $user->mobile_num = $request->input('mobile_num'); 
                    //$user->fax_num = $request->input('fax_num'); 
                    //$user->home_email = $request->input('home_email'); 
                    $user->date_of_birth = $request->input('date_of_birth'); 
                    
                    $feet = $request->input('feet');
                    $inche = $request->input('inche');                    
                    $user->user_height = $feet * 12 + $inche;
                    $user->weight = $request->input('weight');
                    $user->sex = $request->input('sex');

                    $birthDate =  $request->input('date_of_birth');
                    $birthDate = explode("-", $birthDate);                                            
                    $user->age = $this->getAge($birthDate[0],$birthDate[1], $birthDate[2]);// $age; //$request->input('age');
                    
                    $user->company_id = $request->input('company_id'); 
                    $user->user_type_id = $request->input('user_type_id');
                    $user->emr_ehr_id = $request->input('emrid');
                    $user->ethnicity = $request->input('ethnicity');
                    $user->placemaker = $request->input('placemaker');
                                        
                    // $shipping_id = "";
                    // foreach ($request->input('shipping_id') as $cId)
                    //      $shipping_id = $shipping_id.":".$cId;

                    $bill = new  Bill();
                    $bill->billing_country_id = $request->input('billing_country_id');
                    $bill->billing_state_id = $request->input('billing_state_id');
                    $bill->billing_city = $request->input('billing_city');
                    $bill->billing_zip = $request->input('billing_zip');
                    $bill->billing_address1 = $request->input('billing_address1');
                    $bill->billing_address2 = $request->input('billing_address2');
                    $bill->save();       

                    $ship = new Ship();
                    $ship->shipping_country_id = $request->input('shipping_country_id');
                    $ship->shipping_state_id = $request->input('shipping_state_id');
                    $ship->shipping_city = $request->input('shipping_city');
                    $ship->shipping_zip = $request->input('shipping_zip');  
                    $ship->shipping_address1 = $request->input('shipping_address1');  
                    $ship->shipping_address2 = $request->input('shipping_address2');                    
                    $ship->save();
                                             
                    $user->billing_id = $bill->id;
                    $user->shipping_id = $ship->id;
                    $user->save();
                    $patient_id = $user->id;
                }else{
                    $patient_id = $check->first()->id;                    
                }
                                                
                                
                $user_type = 'new';                
                $patient = Users::where('id', $patient_id)->get()->first();
                $symptoms = VisitPurpose::where('type', 'Symptoms')->get();
                $treatment = VisitPurpose::where('type', 'Treatment')->get();
                $disease = VisitPurpose::where('type', 'Disease')->get();                
                $tester_id = Session::get("user_id");

                $from = $request->input('from'); 
                                
                if($patient && $from == 'testland'){
                    $user_diabet = UserDiabet::where('user_id', $patient_id)->get();
                    return view('doctor.prestep.prestep2')
                    ->with('patient', $patient)
                    ->with('user_diabet', $user_diabet);            
                }else{
                    return redirect('doctor/testland');
                    //return redirect()->back();
                }

            }

            $error_msg = "Invalid phone number";                        
        }         
        
        $company = Company::where('history',1)->get();            
        $usertype = UserType::where('user_type_name',"Patient")->get();

        $country = Country::all();
        $state = State::where('country_id', '1')->get();
        $city = City::where('state_id', '1')->orderBy("city_name")->get();
        
        return view('officeManager.patient.addUser')
        ->with('company', $company)
        ->with('country', $country)
        ->with('state', $state)
        ->with('city', $city)
        ->with('page', 'patient')       
        ->with('logintype', Session::get('user_type'))
        ->with('usertype', $usertype)
        ->with('from', "menu")
        ->with('error_msg', $error_msg);
                
    }

    function getAge($year, $month, $day){
        $date = "$year-$month-$day";
        if(version_compare(PHP_VERSION, '5.3.0') >= 0){
            $dob = new DateTime($date);
            $now = new DateTime();
            return $now->diff($dob)->y;
        }
        $difference = time() - strtotime($date);
        return floor($difference / 31556926);
    }


    
    public function getEditpatient($userId = '', Request $request){
         
        $temp = $userId;
        if($request->has('id') ){
            $id = $request->input('id');
            // $shipping_id = "";
            // foreach ($request->input('shipping_id') as $cId)
            //         $shipping_id = $shipping_id.":".$cId;                       
            // 'user_height' => $user_height,  'weight' => $weight, 'home_email' => $home_email ,  'age' => $age,                                    

           

                $mobile_num = $request->input('mobile_num'); 
                $fax_num = $request->input('fax_num'); 
                //$home_email = $request->input('home_email'); 
                $date_of_birth = $request->input('date_of_birth'); 
                

                $feet = $request->input('feet');
                $inche = $request->input('inche');                    
                $user_height = $feet * 12 + $inche;            
                $weight = $request->input('weight');

                $sex = $request->input('sex');
                $emrid = $request->input('emrid');
                //$age = $request->input('age');            

                //'office_num' => $request->input('office_num') ,
                //'fax_num' => $fax_num, 

                $birthDate =  $request->input('date_of_birth');
                $birthDate = explode("-", $birthDate);            
                $age = $this->getAge($birthDate[0],$birthDate[1], $birthDate[2]);
                            
                DB::table('tbl_user')
                ->where('id', $id)
                ->update(['first_name' => $request->input('first_name') , 'last_name' => $request->input('last_name') ,
                'email_address' => $request->input('email_address') , 
                'home_num' => $request->input('home_num'),
                'company_id' => $request->input('company_id') , 'user_type_id' => $request->input('user_type_id'), 
                'mobile_num' => $mobile_num , 
                'date_of_birth' => $date_of_birth,'emr_ehr_id' => $emrid,'age'=>$age,
                'sex' => $sex ,'user_height' => $user_height,  'weight' => $weight,
                'shipping_id' => $request->input('shipping_id')  , 'billing_id' => $request->input('billing_id')]);


                DB::table('tbl_user_billing')
                ->where('auto_num', $request->input('billing_id'))
                ->update(['billing_state_id' => $request->input('billing_state_id') , 'billing_city' => $request->input('billing_city') ,
                'billing_zip' => $request->input('billing_zip'), 'billing_address1' => $request->input('billing_address1'),'billing_address2' => $request->input('billing_address2') ]);

                DB::table('tbl_user_shipping')
                ->where('auto_num', $request->input('shipping_id'))
                ->update(['shipping_state_id' => $request->input('shipping_state_id') , 'shipping_city' => $request->input('shipping_city') ,
                'shipping_zip' => $request->input('shipping_zip'), 'shipping_address1' => $request->input('shipping_address1'), 'shipping_address2' => $request->input('shipping_address2') ]);                                
            


                if($request->input('page_type') == "edit"){
                    return redirect('office/editPatient/'.$id);
                }else{
                    $user = Users::where('id', $id)->get();
                    $user_type = 'new';                
                    $symptoms = VisitPurpose::where('type', 'Symptoms')->get();
                    $treatment = VisitPurpose::where('type', 'Treatment')->get();
                    $disease = VisitPurpose::where('type', 'Disease')->get();                
                    $tester_id = Session::get("user_id");
    
                    return view('doctor.prestep.prestep3')
                        ->with('patient', $user->first())
                        ->with('symptoms', $symptoms)
                        ->with('treatment', $treatment)
                        ->with('disease', $disease)
                        ->with('user_type', $user_type)
                        ->with('tester_id', $tester_id);  
                }
                
                
        }else{
                        
            if($request->has('patient_id') ){
                $userId = $request->input('patient_id');
            }
            

            $company = Company::where('history', 1)->get();
            $usertype = UserType::where('user_type_name', "Patient")->get();
            $user = Users::where('id', $userId)->get();

            //$shipping = Ship::all();
            //$billing = Bill::all();

            $billing = Bill::where('auto_num', $user->first()->billing_id)->get();
            $shipping = Ship::where('auto_num', $user->first()->shipping_id)->get();

            $country = Country::all();
            $state = State::where('country_id', '1')->get();
            if($billing->first()){
                $city = City::where('state_id', $billing->first()->billing_state_id )->orderBy("city_name")->get();
            }else{
                $city = City::where('state_id', '1' )->orderBy("city_name")->get();
            }
            
            $state2 = State::where('country_id', '1')->get();
            if($shipping->first()){
                $city2 = City::where('state_id', $shipping->first()->shipping_state_id )->orderBy("city_name")->get();
            }else{
                $city2 = City::where('state_id', '1')->orderBy("city_name")->get();
            }

            
            
            if( (  $request->has('patient_id')  &&  $request->input('page_type') =='back') || ($temp != null && $temp != "") ) {

                $page_type = "back";
                if($temp != null && $temp != ""){
                    $page_type = "edit";
                }
                return view('officeManager.patient.editUser')
                ->with('country', $country)
                ->with('state', $state)
                ->with('city', $city)
                ->with('city2', $city2)
                ->with('user', $user->first())
                ->with('billing', $billing->first())
                ->with('shipping', $shipping->first())
                ->with('logintype', Session::get('user_type'))
                //->with('company', $company)
                ->with('page', 'patient')
                ->with('page_type', $page_type)
                ->with('usertype', $usertype);
                               
            }else{
                
                $user_type = 'new';                
                $symptoms = VisitPurpose::where('type', 'Symptoms')->get();
                $treatment = VisitPurpose::where('type', 'Treatment')->get();
                $disease = VisitPurpose::where('type', 'Disease')->get();                
                $tester_id = Session::get("user_id");

                return view('doctor.prestep.prestep3')
                    ->with('patient', $user->first())
                    ->with('symptoms', $symptoms)
                    ->with('treatment', $treatment)
                    ->with('disease', $disease)
                    ->with('user_type', $user_type)
                    ->with('tester_id', $tester_id);     

               
            }
            
        }               
    }
    
    public function getTestinformation()
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

        $data['phase4'] = Allocation::where('company_id', Session::get('company_id'))->where('is_allocated', '2')->where('step', '>=' , '1')->get()->count();
        $data['phase3'] = Allocation::where('company_id', Session::get('company_id'))->where('is_allocated', '2')->where('step', '>=' , '1')->where('step', '<' , '4')->get()->count();
        $data['phase2'] = Allocation::where('company_id', Session::get('company_id'))->where('is_allocated', '2')->where('step', '>=' , '1')->where('step', '<' , '3')->get()->count();
        $data['phase1'] = Allocation::where('company_id', Session::get('company_id'))->where('is_allocated', '2')->where('step', '>=' , '1')->where('step', '<' , '2')->get()->count();
        $data['test_aborts'] = Allocation::where('company_id', Session::get('company_id'))->where('is_allocated', '2')->get()->count();


        $allocation = Allocation::where('company_id', Session::get('company_id'))->get();
        foreach($allocation as $allo){
            $admin = Users::where('id', $allo->administer_num)->get();
            if($admin->first()){
                $allo->administer_num = $admin->first()->first_name;
            }
        }
        
        return view('officeManager.testInformation')
        ->with('allocation', $allocation)
        ->with('patients', $patients)
        ->with('data', $data);
    }

    ///// --------------------------------------- user management ---------------------------------
    public function getUsers($id = '' , Request $request = null){
                
        $user = UserType::where('user_type_name', "Patient")->get();
        $users = Users::where('company_id', Session::get('company_id'))
        ->where('id', '!=', Session::get('user_id'))
        ->where('user_type_id', '>', 1)
        ->where('user_type_id', '!=' , $user->first()->auto_num)
        ->get();        

        foreach($users as $user){
            $company = Company::where('auto_num', $user->company_id)->get();  
            if($company->first()) {
                $user->company_id = $company->first()->company_name;
            }else{
                $user->company_id = "Admin";
            }
            $userType = UserType::where('auto_num', $user->user_type_id)->get();
            if($userType->first()){
                $user->user_type_id = $userType->first()->user_type_name;
            }else{
                $user->user_type_id = "Unknown";
            }            
        }
        return view('officeManager.user.users')
        ->with('users', $users)
        ->with('page', 'user')  //  patient, or user
        ->with('type', $id); // action, edit, delete
    }

    
    public function getAdduser($id = '' , Request $request = null){    

        if($request != null && $request->has('email_address')){                 
            $pwd = $request->input('user_password'); 
            $cpwd = $request->input('confirmPassword');
            if($pwd == $cpwd){
                
                $check = Users::where('email_address', $request->input('email_address'))->get();

                if(!$check->first()){                    
                    $user = new Users();
                    $user->first_name = $request->input('first_name'); 
                    $user->last_name = $request->input('last_name'); 
                    $user->email_address = $request->input('email_address'); 
                    $user->user_password = $request->input('user_password'); 
                    $user->office_num = $request->input('office_num'); 
                    $user->home_num = $request->input('home_num'); 
                    $user->company_id = $request->input('company_id'); 
                    $user->user_type_id = $request->input('user_type_id');
                    //$user->billing_id = $request->input('billing_id');
                    
                    //$shipping_id = "";
                    //foreach ($request->input('shipping_id') as $cId)
                    //        $shipping_id = $shipping_id.":".$cId;
                    //$user->shipping_id = $shipping_id;
                                   
                    $user->save();

                    // send email                    
                    $data = array(
                        'name' => $request->input('first_name')." ".$request->input('last_name'),
                        'message'=> "Create Account",
                        'id' => $user->id
                    );      
                              
                    Mail::send('email', ["data"=>$data], function ($message) use ($request) {
                        $message->from('newuser@prohealthdetect.com', 'New User');
                        $message->subject('Create a new Account');
                        $message->to($request->input('email_address'));
                    });
                                    
                    //Mail::to($request->input('email_address'))->send(new Send($data));                                        
                    return redirect('office/users/add');                    
                }else{
                    //return redirect()->back();
                    $shipping = Ship::all();
                    $billing = Bill::all();
                    $company = Company::where('history', 1)->get();            
                    $usertype = UserType::where('auto_num', '>', 1)
                    ->where('user_type_name', '!=' , 'Patient')
                    ->get();            
                    return view('officeManager.user.addUser')
                    ->with('company', $company)
                    ->with('shipping', $shipping)
                    ->with('billing', $billing)
                    ->with('page', 'user')
                    ->with('exist', '1')
                    ->with('usertype', $usertype);   
                }                
            }else{
                return redirect()->back();                                             
            }
            
        }else{
            $shipping = Ship::all();
            $billing = Bill::all();
            $company = Company::where('history', 1)->get();            
            $usertype = UserType::where('auto_num', '>', 1)
            ->where('user_type_name', '!=' , 'Patient')
            ->get();            
            return view('officeManager.user.addUser')
            ->with('company', $company)
            ->with('shipping', $shipping)
            ->with('billing', $billing)
            ->with('page', 'user')
            ->with('exist', '0')
            ->with('usertype', $usertype);
        }
    }


    public function getEdituser($userId = '', Request $request){
        $id = $request->input('id');
        if($request->has('id')){      
            
            //$shipping_id = "";
            //foreach ($request->input('shipping_id') as $cId)
            //        $shipping_id = $shipping_id.":".$cId;

             DB::table('tbl_user')
            ->where('id', $id)
            ->update(['first_name' => $request->input('first_name') , 'last_name' => $request->input('last_name') ,
            'email_address' => $request->input('email_address') , 'user_password' => $request->input('user_password'),
            'office_num' => $request->input('office_num') , 'home_num' => $request->input('home_num'),
            'company_id' => $request->input('company_id') , 'user_type_id' => $request->input('user_type_id') ]);

            //'shipping_id' => $shipping_id  , 'billing_id' => $request->input('billing_id')

            return redirect('office/editUser/'.$id);

        }else{

            $company = Company::where('history', 1)->get();
            $usertype = UserType::where('user_type_name', '!=', "Patient")->where('auto_num', '>', 1)->get();
            $user = Users::where('id', $userId)->get();
            $shipping = Ship::all();
            $billing = Bill::all();

            return view('officeManager.user.editUser')
            ->with('shipping', $shipping)
            ->with('billing', $billing)
            ->with('user', $user->first())
            //->with('company', $company)
            ->with('page', 'user')
            ->with('usertype', $usertype);
        }               
    }


    // -----------------------------------------  office information -----------------------------------------------------------------------
    public function getOfficeInformation($userId = '', Request $request){

        if($userId == ''){
            $userId = Session::get('company_id');
        }
                
        $id = $request->input('id');
        
        if($request->has('company_name')){

            switch ($request->input('action')) {
                case 'update':
                
                    // before update, move current value to history record
                    $data = Company::where('auto_num', $id)->get()->first();
                    DB::table('tbl_company')
                    ->where('original_id', $id)
                    ->update(['company_name' => $data->company_name,
                    'physical_address1' => $data->physical_address1,
                    'physical_address2' => $data->physical_address2,
                    'physical_country_id' => $data->physical_country_id,
                    'physical_city' => $data->physical_city,
                    'physical_zip' => $data->physical_zip,
        
                    'mailing_address1' => $data->mailing_address1,
                    'mailing_address2' => $data->mailing_address2,
                    'mailing_country_id' => $data->mailing_country_id,
                    'mailing_city' => $data->mailing_city,
                    'mailing_state_id' => $data->mailing_state_id,
                    'mailing_zip' => $data->mailing_zip,
                    'office_phone' => $data->office_phone,
                    'office_fax' => $data->office_fax,
                    'office_website' => $data->office_website,
                    'office_email' => $data->office_email ]);

                    // save data
                    $name = $request->input('company_name');            
                    DB::table('tbl_company')
                    ->where('auto_num', $id)
                    ->update(['company_name' => $name,
                    'physical_address1' => $request->input('physical_address1'),
                    'physical_address2' => $request->input('physical_address2'),
                    'physical_country_id' => $request->input('physical_country_id'),
                    'physical_city' => $request->input('physical_city'),
                    'physical_zip' => $request->input('physical_zip'),
        
                    'mailing_address1' => $request->input('mailing_address1'),
                    'mailing_address2' => $request->input('mailing_address2'),
                    'mailing_country_id' => $request->input('mailing_country_id'),
                    'mailing_city' => $request->input('mailing_city'),
                    'mailing_state_id' => $request->input('mailing_state_id'),
                    'mailing_zip' => $request->input('mailing_zip'),
                    'office_phone' => $request->input('office_phone'),
                    'office_fax' => $request->input('office_fax'),
                    'office_website' => $request->input('office_website'),
                    'office_email' => $request->input('office_email') ]);
                    return redirect('office/officeInformation');

                    break;        
                case 'cancel':
                    $data = Company::where('original_id', $id)->get()->first();
                    DB::table('tbl_company')
                    ->where('auto_num', $id)
                    ->update(['company_name' => $data->company_name,
                    'physical_address1' => $data->physical_address1,
                    'physical_address2' => $data->physical_address2,
                    'physical_country_id' => $data->physical_country_id,
                    'physical_city' => $data->physical_city,
                    'physical_zip' => $data->physical_zip,
        
                    'mailing_address1' => $data->mailing_address1,
                    'mailing_address2' => $data->mailing_address2,
                    'mailing_country_id' => $data->mailing_country_id,
                    'mailing_city' => $data->mailing_city,
                    'mailing_state_id' => $data->mailing_state_id,
                    'mailing_zip' => $data->mailing_zip,
                    'office_phone' => $data->office_phone,
                    'office_fax' => $data->office_fax,
                    'office_website' => $data->office_website,
                    'office_email' => $data->office_email ]);
                    return redirect('office/officeInformation');
                    break;                        
            }
            
        }else{                        
        
            $user = Company::where('auto_num', $userId)->get();       
            if($user->first()){
                $physical_state_id = $user->first()->physical_state_id;
                $mailing_state_id = $user->first()->mailing_state_id;
    
                $country = Country::all();
                $state = State::where('country_id', '1')->get();
                $physical_city = City::where('state_id', $physical_state_id )->orderBy("city_name")->get();
                $mailing_city = City::where('state_id', $mailing_state_id )->orderBy("city_name")->get();
    
                return view('officeManager.officeInformation')
                ->with('user', $user->first())
                ->with('country', $country)
                ->with('state', $state)
                ->with('physical_city', $physical_city)
                ->with('mailing_city', $mailing_city);
            }else{
                return redirect('office/dashboard');
            }                               
        }                        
    }


    // ----------------------------------------------   order suppliers -------------------------------------------------     
    
    public function getSuppliers($userId = '', Request $request){
        return view('officeManager/suppliers',  compact('script'));
        //return redirect('office/supplyrefresh');
    }

    public function getSync($userId = '', Request $request){
        $phd = json_decode( file_get_contents('https://prohealthdetect.com/phd-store/index.php?rt=a/product/filter&api_key=1mzP2T12A4dB7H0e&product_id=1&category_id=71'), true  );
        
        DB::table('tbl_products')->delete();    

        $rows1 = $phd['rows'];
        foreach($rows1 as $row){
            $product  = new Product();
            $product->content = json_encode($row);
            $product->save();            
        }

        $sensors = json_decode( file_get_contents('https://prohealthdetect.com/phd-store/index.php?rt=a/product/filter&api_key=1mzP2T12A4dB7H0e&product_id=1&category_id=72'), true );

        $rows2 = $sensors['rows'];
        foreach($rows2 as $row){
            $product  = new Product();
            $product->content = json_encode($row);
            $product->save();            
        }
        
        $a = array('results'=>200);
        return Response::json($a);        
    }


    public function getSuppliers2($userId = '', Request $request){
        
        $products = Product::all();
        $user_id = Session::get('user_id');
        $user = Users::where('id', $user_id)->get();
        if($user->first()){
            $company_id = $user->first()->company_id;
        }

        $company = Company::where('auto_num', $company_id)->get();
        $username = "";
        $password = "";
        if($company->first()){
            $string = preg_replace('/\s+/', '', $company->first()->company_name);
            $username = $string."517";
            $password = "aaAA11!!";
            //$password = "123456";
        }

        return view('officeManager/suppliers2',  compact('script'))
        ->with('products', $products)
        ->with('username', $username)
        ->with('password', $password);        
    }

    public function getCard($userId = '', Request $request){
        

        $user_id = Session::get('user_id');
        $user = Users::where('id', $user_id)->get();
        if($user->first()){
            $company_id = $user->first()->company_id;
        }

        $company = Company::where('auto_num', $company_id)->get();
        $username = "";
        $password = "";
        if($company->first()){
            $string = preg_replace('/\s+/', '', $company->first()->company_name);
            $username = $string."517";
            $password = "aaAA11!!";
            //$password = "123456";
        }

        return view('officeManager/payment/card',  compact('script'))
        ->with('username', $username)
        ->with('password', $password);        
    }


    public function getCheckout($userId = '', Request $request){
        
        $token = $request->input('token');
                
        $user_id = Session::get('user_id');
        $user = Users::where('id', $user_id)->get();
        if($user->first()){
            $company_id = $user->first()->company_id;
        }

        $company = Company::where('auto_num', $company_id)->get();
        $username = "";
        $phone = "";
        
        if($company->first()){
            $string = preg_replace('/\s+/', '', $company->first()->company_name);
            $username = $company->first()->first_name." ".$company->first()->last_name;
            $phone = $company->first()->office_phone;
            //$password = "123456";
        }

        return view('officeManager/payment/checkout',  compact('script'))
        ->with('token', $token)
        ->with('username', $username)
        ->with('phone', $phone);

    }



    public function getSupplyrefresh(){
        return view('officeManager/suppliers');
    }
        
    public function getOfficemessages($userId = '', Request $request){

        $current_date = date("Y-m-d", time());;

        $all  = Message::all();

        $data['total_message']  = $all->count();
        $data['active_message'] = Message::where('expire_date','>' ,$current_date)->get()->count();
        $data['expire_message'] = Message::where('expire_date','<' ,$current_date)->get()->count();
        
        $messages = Message::all();

        return view('officeManager/officeMessages')
        ->with('data', $data)
        ->with('messages', $messages);
        
    }

    
    public function getAddmessage($userId = '', Request $request){
             
    }


    public function getPassword($userId = '', Request $request)
    {        
        if($userId != null ){
            $user =  Users::where('id', $userId)->get()->first();
            if($user){
                if($user->is_active == "1" & $user->user_password != null){
                    return redirect('login');
                }else{
                    DB::table('tbl_user')
                    ->where('id', $userId)
                    ->update(['is_active' => 1]);                                                

                    return view('officeManager.password')
                        ->with('id', $userId);
                }
            }                     
        }
                
        return redirect('login');        
    }    
}
