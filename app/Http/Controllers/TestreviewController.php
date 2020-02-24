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


class TestreviewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
    public function getTestPatients(){

        //$user_id = Session::get("user_id");
        //$user_type = UserType::where('user_type_name',$user_id)->get();

        $user_type = UserType::where('user_type_name','Patient')->get();
        $patients = Users::where('user_type_id',$user_type->first()->auto_num)
            ->join('tbl_allocation', 'tbl_user.id', '=', 'tbl_allocation.user_num')
            ->where('is_allocated', '0') // 0  mean completed status.
            ->where('tbl_allocation.company_id', Session::get('company_id'))
            ->groupBy('id')            
            ->orderBy("first_name")
            ->get();
        return view('review.patientlists')
            ->with('patients', $patients);            
    }


    public function getTestlists($id = '' , Request $request = null){
        
        $patient_id = $request->input('patient_id');
        $patient = Users::where('id', $patient_id)->get()->first();
        $allocations = Allocation::where('user_num', $patient_id)
            ->where('is_allocated', '0')
            ->orderBy('auto_num', 'DESC')
            ->get();

        return view('review.testlists')
            ->with('patient', $patient)
            ->with('allocations', $allocations);
    }
    


}
