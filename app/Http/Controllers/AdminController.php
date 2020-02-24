<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\CommonHelper;
use App\Models\CommonWorker;
use App\Models\AdminWorker;
use Response;
use DB;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Mail;
use App\Mail\Send;

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
use App\VisitPurpose;
use Session;

class AdminController extends BaseController
{    
    /**
     * Function for getting admin dashboard page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __construct()
    {
        
    }

    public function getIndex()
    {
        return view('admin.usermanagement.dashboard');
    }
    
    public function test(){
        $data = array(
            'name' => 'name',
            'message'=> 'message',
            'id'=>1
        );

        Mail::send('email', ["data"=>$data], function ($message)  {
                        $message->from('newuser@prohealthdetect.com', 'New User');
                        $message->subject('Create a new Account');
                        $message->to('kingstarboy@outlook.com');
                    });    
        //Mail::to('kingstarboy@outlook.com')->send(new Send($data));
        dd(Mail::failures());
        return json_encode($res);
                
    }
  

    
    
    public function getDashboard()
    {
        $allocation = Allocation::where('administer_num', Session::get('user_id'))->where('is_allocated','1')->get();
        return view('admin.usermanagement.dashboard')
        ->with('allocation', $allocation);
    }
    

    

    
    public function getGraphic(){

        $allocation = Allocation::where('administer_num', Session::get('user_id'))->where('is_allocated','1')->get();
        $user_type = UserType::where('user_type_name','Patient')->get();
        $patients = Users::where('user_type_id',$user_type->first()->auto_num)->where('company_id', Session::get('company_id'))->get();
        $devices = Device::where('company_id', Session::get('company_id'))->get();

        return view('admin.analytic.graphic')
        ->with('patients', $patients)
        ->with('devices', $devices)
        ->with('allocation', $allocation);
    }
        
    public function getTables(){                
        $allocation = Allocation::where('administer_num', Session::get('user_id'))->where('is_allocated','1')->get();
        $user_type = UserType::where('user_type_name','Patient')->get();
        $patients = Users::where('user_type_id',$user_type->first()->auto_num)->where('company_id', Session::get('company_id'))->get();
        $devices = Device::where('company_id', Session::get('company_id'))->get();
        
        return view('admin.analytic.tables')
        ->with('patients', $patients)
        ->with('devices', $devices)
        ->with('allocation', $allocation);
        
    }

    public function getHistory(){

        $allocation = Allocation::where('administer_num', Session::get('user_id'))->where('is_allocated','1')->get();
        $user_type = UserType::where('user_type_name','Patient')->get();
        $patients = Users::where('user_type_id',$user_type->first()->auto_num)->where('company_id', Session::get('company_id'))->get();
        $devices = Device::where('company_id', Session::get('company_id'))->get();

        return view('admin.analytic.history')
        ->with('patients', $patients)
        ->with('devices', $devices)
        ->with('allocation', $allocation);
    }

    public function getTest(){   
        return view('admin.analytic.test');        
    }

    
    // -------------------------------------------- setting ----------------------------------------------    
    public function getCountry(){
        $country = Country::all();        
        return view('admin.setting.country')->with('country', $country);
    }

    public function getState(){
        $state = State::all();
        foreach($state as $s){
            $name = Country::where('auto_num', $s->country_id)->get();
            $s->country_id = $name->first()->country_name;            
        }        
        return view('admin.setting.state')->with('state', $state);
    }
    

    public function getCities(){
        //$city = City::paginate(150);
        // foreach($city as $s){
        //     $name = State::where('auto_num', $s->state_id)->get();
        //     $s->state_id = $name->first()->state_name;            
        // }
        return view('admin.setting.cities');//->with('city', $city);
    }
    // -------------------------------------------- user managment ----------------------------------------
    public function getUsers(){

        if(Session::get('company_id') == '0'){ // in the case of super admin            
            $user = UserType::where('user_type_name', "Office Manager")->get();
            if($user->first()){
                $users = Users::where('company_id', '!=',  Session::get('company_id'))
                ->where('user_type_id', $user->first()->auto_num)
                ->get();
            }else{
                $users = Users::where('company_id', '!=',  Session::get('company_id'))                
                ->get();
            }                        
        }else{ // other company customers
            $users = Users::where('company_id', Session::get('company_id'))
            ->where('id', '!=', Session::get('user_id'))
            ->get();
        }
        

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

        return view('admin.usermanagement.users')
        ->with('page', 'office')
        ->with('users', $users);
    }


    public function getAllusers(){

        if(Session::get('company_id') == '0'){ // in the case of super admin            
            $user = UserType::where('user_type_name', "Office Manager")->get();
            $users = Users::where('company_id', '!=',  Session::get('company_id'))                
            ->get();                     
        }else{ // other company customers
            $users = Users::where('company_id', Session::get('company_id'))
            ->where('id', '!=', Session::get('user_id'))
            ->get();
        }
        

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
        return view('admin.usermanagement.users')
        ->with('page', 'all')
        ->with('users', $users);
    }

    public function users(){
        return redirect('admin/users');
    }
    

    public function getAdduser($id = '' , Request $request = null){    

        if($request != null && $request->has('email_address')){                 
            //$pwd = $request->input('user_password'); 
            //$cpwd = $request->input('confirmPassword');
            if(true){
                $check = Users::where('email_address', $request->input('email_address'))->get();
                if(!$check->first()){      
                    $user = new Users();                
                    $user->first_name = $request->input('first_name'); 
                    $user->last_name = $request->input('last_name'); 
                    $user->email_address = $request->input('email_address'); 
                    //$user->user_password = $request->input('user_password'); 
                    $user->office_num = $request->input('office_num'); 
                    $user->home_num = $request->input('home_num'); 
                    $user->company_id = $request->input('company_id'); 
                    $user->user_type_id = $request->input('user_type_id');

                    //$user->billing_id = $request->input('billing_id');

                    // $shipping_id = "";
                    // foreach ($request->input('shipping_id') as $cId)
                    //      $shipping_id = $shipping_id.":".$cId;
                    // $user->shipping_id = $shipping_id;

                    $user->save();
                    // send email                    
                    $data = array(
                        'name' => $request->input('first_name')." ".$request->input('last_name'),
                        'message'=> "Create Account",
                        'id' => $user->id
                    );

                    try{                        
                        $validate = Mail::send('email', ["data"=>$data], function ($message) use ($request) {
                            $message->from('newuser@prohealthdetect.com', 'New User');
                            $message->subject('Create a new Account');
                            $message->to($request->input('email_address'));
                        });

                        // if( $validate->fails() ){                            

                        // }else{                            

                        // }
                    }catch(Exception $e){
                        // Never reached
                        return redirect()->back();
                    }                    
                    //Mail::to($request->input('email_address'))->send(new Send($data));
                }
                return redirect('admin/users');                                
            }else{
                return redirect()->back();                
            }

        }else{  
            
            $shipping = Ship::all();
            $billing = Bill::all();
            $company = Company::where('history', 1)->orderBy("company_name")->get();      
            $usertype = UserType::where('user_type_name', '!=' , "Office Manager")->get();

            if(Session::get('user_type') == "0"){
                $usertype = UserType::where('user_type_name', "Office Manager")->get();
            }

            return view('admin.usermanagement.addUser')
            ->with('company', $company)
            ->with('cid', $id)
            ->with('shipping', $shipping)
            ->with('billing', $billing)
            ->with('usertype', $usertype);
        }

    }

    public function getEdituser($userId = '', Request $request){

        $id = $request->input('id');
        if($request->has('id')){      
            
            // $shipping_id = "";
            // foreach ($request->input('shipping_id') as $cId)
            //         $shipping_id = $shipping_id.":".$cId;

             DB::table('tbl_user')
            ->where('id', $id)
            ->update(['first_name' => $request->input('first_name') , 'last_name' => $request->input('last_name') ,
            'email_address' => $request->input('email_address') , 
            'office_num' => $request->input('office_num') , 'home_num' => $request->input('home_num'),
            'company_id' => $request->input('company_id') , 'user_type_id' => $request->input('user_type_id') ]);
            
            //'user_password' => $request->input('user_password'),            
            return redirect('admin/editUser/'.$id);
        }else{    
            
            $usertype = UserType::all();
            $company = Company::where('history', 1)->get();
            $user = Users::where('id', $userId)->get();     
            $shipping = Ship::all();
            $billing = Bill::all();
            return view('admin.usermanagement.editUser')
            ->with('shipping', $shipping)
            ->with('billing', $billing)
            ->with('user', $user->first())
            ->with('company', $company)
            ->with('usertype', $usertype);
        }      
    }
    
    // --------------------------------------------- user type ----------------------------------------------
    public function getUsertype(){
        $usertypes = UserType::all();
        return view('admin.usertype.userTypes')->with('usertypes',$usertypes);
    }

    public function getAddusertype($id = '' , Request $request = null){    
        if($request != null && $request->has('name')){            
            $name = $request->input('name');                        
            $role = $request->input('role');
            $check = UserType::where('user_type_name', $name)->get();
            if(!$check->first()){      
                $user = new UserType();                
                $user->user_type_name = $name;     
                $user->role = $role;                           
                $user->save();              
            }
            $users = UserType::all();
            return view('admin.usertype.userTypes')->with('usertypes', $users);
        }else{            
            return view('admin.usertype.addUserType');
        }       
    }

    public function getEditusertype($userId = '', Request $request){
        $id = $request->input('id');
        if($request->has('name')){           
            $name = $request->input('name');
            $role = $request->input('role');
             DB::table('tbl_user_type')
            ->where('auto_num', $id)
            ->update(['user_type_name' => $name, 'role' => $role]);            
            $user = UserType::where('auto_num', $id)->get();
            return view('admin.usertype.editUserType')->with('user', $user->first());         
        }else{            
            $user = UserType::where('auto_num', $userId)->get();
            return view('admin.usertype.editUserType')->with('user', $user->first());
        }      
    }

    
    //------------------------------------------------ company ------------------------------------------
    
    public function getCompany(){
        $com = Company::where('history', '1')->get();
        return view('admin.company.companyLists')->with('companies',$com);
    }

    public function getAddcompany($id = '' , Request $request = null){    

        if($request != null && $request->has('company_name')){      

            $check = Company::where('company_name', $request->input('company_name'))->get();
            if(!$check->first()){      
                $user = new Company();                
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

            }
            $users = Company::where('history', 1);
            return redirect('admin/company');
            //return view('admin.company.companyLists')->with('companies', $users);
        }else{

            $country = Country::all();
            $state = State::where('country_id', '1')->get();
            $city = City::where('state_id', '1')->orderBy("city_name")->get();
            return view('admin.company.addCompany')
            ->with('country',$country)
            ->with('state', $state)
            ->with('city', $city);

        }        
    }
    
    public function getEditcompany($userId = '', Request $request){
        $id = $request->input('id');
        if($request->has('company_name')){           
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

            return redirect('admin/editCompany/'.$id);

        }else{                        
            $user = Company::where('auto_num', $userId)->get();            
            $physical_state_id = $user->first()->physical_state_id;
            $mailing_state_id = $user->first()->mailing_state_id;

            $country = Country::all();
            $state = State::where('country_id', '1')->get();
            $physical_city = City::where('state_id', $physical_state_id )->orderBy("city_name")->get();
            $mailing_city = City::where('state_id', $mailing_state_id )->orderBy("city_name")->get();

            return view('admin.company.editCompany')
            ->with('user', $user->first())
            ->with('country', $country)
            ->with('state', $state)
            ->with('physical_city', $physical_city)
            ->with('mailing_city', $mailing_city);

        }      
    }


    // ------------------------------------------------ device ------------------------------------------
    public function getDevices(){        
        $com = Device::all();
        foreach($com as $s){
            $name = Company::where('auto_num', $s->company_id)->get();
            if($name->first()){
                $s->company_id = $name->first()->company_name;            
            }else{
                $s->company_id = "Unknown";
            }            
        }        
        return view('admin.device.devices')
        ->with('devices',$com);
    }


        
    public function getAdddevice($id = '' , Request $request = null){    

        if($request != null && $request->has('serial_num')){      

            $check = Device::where('serial_num', $request->input('serial_num'))->get();
            if(!$check->first()){      
                $user = new Device();                
                $user->serial_num = $request->input('serial_num');
                $user->company_id = $request->input('company_id');
                $user->save();              
            }            
            return redirect('admin/devices');            
        }else{            
            $company = Company::where('history', 1)->get();
            return view('admin.device.addDevice')->with('company', $company);
        }        
    }
    
    public function getEditdevice($userId = '', Request $request){
        $id = $request->input('id');
        if($request->has('serial_num')){           
            $name = $request->input('serial_num');  
            $company_id = $request->input('company_id');
             DB::table('tbl_device')
            ->where('auto_num', $id)
            ->update(['serial_num' => $name, 'company_id' => $company_id ]);

            return redirect('admin/editDevice/'.$id);

        }else{
            $user = Device::where('auto_num', $userId)->get();
            $company = Company::where('history', 1)->get();
            return view('admin.device.editDevice')
            ->with('user', $user->first())
            ->with('company', $company);
        }
    }        
    //------------------------------------------------ shipping ------------------------------------------
    public function getShips(){
        $com = Ship::all();
        return view('admin.ship.ships')->with('ships',$com);
    }


    public function getAddship($id = '' , Request $request = null){    

        if($request != null && $request->has('shipping_address1')){          

            $check = Ship::where('shipping_address1', $request->input('shipping_address1'))->get();
            if(!$check->first()){    

                $user = new Ship();                  
                $user->user_id = $request->input('user_id');
                $user->shipping_address1 = $request->input('shipping_address1');
                $user->shipping_address2 = $request->input('shipping_address2');             
                $user->shipping_city = $request->input('shipping_city');  
                $user->shipping_state_id = $request->input('shipping_state');  
                $user->shipping_zip = $request->input('shipping_zip');  
                $user->shipping_country_id = $request->input('shipping_country');
                $user->save();              
            }                
            return redirect('admin/ships');                
        }else{            
            

            $country = Country::all();
            $state = State::where('country_id', '1')->get();
            $city = City::where('state_id', '1')->orderBy("city_name")->get();
            
            return view('admin.ship.addShip')                        
            ->with('country', $country)
            ->with('state', $state)
            ->with('city', $city);
        }   
    }
    
    public function getEditship($userId = '', Request $request){        
        $id = $request->input('id');        
        if($request->has('shipping_address1')){      

             DB::table('tbl_user_shipping')
            ->where('auto_num', $id)
            ->update(['shipping_address1' => $request->input('shipping_address1'), 'shipping_address2' => $request->input('shipping_address2'),
            'shipping_city' => $request->input('shipping_city'), 'shipping_zip' => $request->input('shipping_zip'),
            'shipping_state_id' => $request->input('shipping_state_id'), 'shipping_country_id' => $request->input('shipping_country_id'),
            'user_id' => $request->input('user_id')]);
                          
            $user = Ship::where('auto_num', $id)->get();
            $users = Users::all();
            $country = Country::all();

            //return view('admin.ship.editShip')->with('user', $user->first())->with('users',  $users)->with('country', $country);
            return redirect('admin/editShip/'.$id);

        }else{            
            $ship = Ship::where('auto_num', $userId)->get();                              
            $shipping_state_id = $ship->first()->shipping_state_id;

            $country = Country::all();
            $state = State::where('country_id', '1')->get();
            $city = City::where('state_id', $shipping_state_id )->orderBy("city_name")->get();

            return view('admin.ship.editShip')
            ->with('user', $ship->first())
            ->with('country', $country)
            ->with('state', $state)
            ->with('city', $city);
        }      
    }

    //------------------------------------ bill -----------------------
    public function getBills(){
        $usertypes = Bill::all();
        return view('admin.bill.bills')->with('bills',$usertypes);
    }

    public function getAddbill($id = '' , Request $request = null){    

        if($request != null && $request->has('billing_address1')){            
            $billing_address1 = $request->input('billing_address1');
            $check = Bill::where('billing_address1', $billing_address1)->get();
            if(!$check->first()){      
                $user = new Bill();                
                $user->billing_address1 = $request->input('billing_address1');
                $user->billing_address2 = $request->input('billing_address2');                                
                $user->billing_zip = $request->input('billing_zip');

                $user->billing_country_id = $request->input('billing_country_id');
                $user->billing_state_id = $request->input('billing_state_id');
                $user->billing_city = $request->input('billing_city');
                //$user->user_id = $request->input('user_id');
                $user->save();              
            }
            return redirect('admin/bills');
        }else{            
            
            $country  = Country::all();
            $state = State::where('country_id', '1')->get();
            $city = City::where('state_id', '1')->orderBy("city_name")->get();

            return view('admin.bill.addBill')
            ->with('country', $country)
            ->with('state', $state)
            ->with('city', $city);
        }       
    }

    public function getEditbill($userId = '', Request $request){
        
        $id = $request->input('id');        
        if($request->has('billing_address1')){      

             DB::table('tbl_user_billing')
            ->where('auto_num', $id)
            ->update(['billing_address1' => $request->input('billing_address1'), 'billing_address2' => $request->input('billing_address2'),
            'billing_city' => $request->input('billing_city'), 'billing_state_id' => $request->input('billing_state_id'),
            'billing_zip' => $request->input('billing_zip'), 'billing_country_id' => $request->input('billing_country_id'),
            'user_id' => $request->input('user_id')]);
                          
            
            $user = Bill::where('auto_num', $id)->get();      
            $country = Country::all();
            $state = State::where('country_id', '1')->get();
            $city = City::where('state_id', $request->input('billing_state_id'))->orderBy("city_name")->get();
            
            return redirect('admin/editBill/'.$id);
        

        }else{            
            
            
            $bill = Bill::where('auto_num', $userId)->get();      
            $billing_state_id = $bill->first()->billing_state_id;
            $country = Country::all();
            $state = State::where('country_id', '1')->get();
            $city = City::where('state_id', $billing_state_id)->orderBy("city_name")->get();

            return view('admin.bill.editBill')
            ->with('user', $bill->first())
            ->with('country', $country)
            ->with('state', $state)
            ->with('city', $city);
        }      
    }



    
    // --------------------------------------------- symptoms type ----------------------------------------------
    public function getSymptoms(){
        $symptoms = VisitPurpose::where('type', 'Symptoms')->get();
        return view('admin.visitsetting.symptoms')->with('symptoms',$symptoms);
    }
    public function getDisease(){
        $diseases = VisitPurpose::where('type', 'Disease')->get();
        return view('admin.visitsetting.diseases')->with('diseases',$diseases);
    }
    public function getTreatment(){
        $treatments = VisitPurpose::where('type', 'Treatment')->get();
        return view('admin.visitsetting.treatments')->with('treatments',$treatments);
    }


    public function getAddsymptoms($id = '' , Request $request = null){    

        if($request != null && $request->has('title')){            
            $data = $request->all();
            VisitPurpose::create($data);
            $symptoms = VisitPurpose::where('type', 'Symptoms')->get();
            return view('admin.visitsetting.symptoms')->with('symptoms',$symptoms);            
        }else{            
            return view('admin.visitsetting.addSymptoms');
        }
    }

    public function getEditsymptoms($userId = '', Request $request){
        $id = $request->input('id');
        if($request->has('name')){    

            $data = $request->all();
            $visit = VisitPurpose::find($id);
            $visit->update($data);        
            $symptom = VisitPurpose::where('id', $id)->get();
            return view('admin.visitsetting.editSymptoms')->with('symptom', $symptom->first());         
        }else{            
            $symptom = VisitPurpose::where('id', $id)->get();
            return view('admin.visitsetting.editSymptoms')->with('symptom', $symptom->first());
        }      
    }


    public function getTestland(){
        return view('doctor.testland');
    }

    


    


        
}
