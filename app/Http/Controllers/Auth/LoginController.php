<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Response;
use App\Users;
use Session;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $table = 'tbl_user';
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function getLogin($id = '', Request $request){
        
        $email = $request->input('email');
        $password = $request->input('password');       


        $check = Users::where('email_address', $email)->where('user_password', $password)->get();
        if($check->first()){            
            Session::put('user_id', $check->first()->id);
            Session::put('first_name', $check->first()->first_name);
            Session::put('email', $check->first()->email_address);
            Session::put('user_type', $check->first()->user_type_id);
            Session::put('company_id', $check->first()->company_id);

            $users = Users::all();
            //return view('admin.usermanagement.dashboard');
            if(Session::get('user_type') == '0'){
                return redirect('admin/dashboard');
            }elseif(Session::get('user_type') == '1'){
                return redirect('office/dashboard');
            }else{
                return redirect('doctor/testland');
            }            
        }                
        return view('admin.login')
            ->with('error_msg', "Incorrect Credentials");
    }
    
    
    public function logout(Request $request ){        
        //$request->session()->flush();
        //$request->session()->regenerate();
        Session::flush();
        return redirect('/');                
    }


    public function UpdatePwd(Request $request){        
        $userId = $request->input('id');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        if($password == $confirm_password){

            DB::table('tbl_user')
            ->where('id', $userId)
            ->update(['user_password' => $password]);
                        
            $email = Users::where('id', $userId)->get()->first()->email_address;
            $check = Users::where('email_address', $email)->where('user_password', $password)->get();
            if($check->first()){            
                Session::put('user_id', $check->first()->id);
                Session::put('first_name', $check->first()->first_name);
                Session::put('email', $check->first()->email_address);
                Session::put('user_type', $check->first()->user_type_id);
                Session::put('company_id', $check->first()->company_id);

                $users = Users::all();
                //return view('admin.usermanagement.dashboard');
                if(Session::get('user_type') == '0'){
                    return redirect('admin/dashboard');
                }elseif(Session::get('user_type') == '1'){
                    return redirect('office/dashboard');
                }elseif(Session::get('user_type') == '2' || Session::get('user_type') == '3' || Session::get('user_type') == '4'){
                    return redirect('doctor/testland');
                }else{
                }         
            }                     
            return view('admin.login');
        }
        return redirect()->back();
                        
    }


}
