<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Session;

class ImportController extends Controller
{
    //

    public function getIndex(){
        return view('admin.usermanagement.import');
    }

    public function getExport() 
    {
        $company_id = Session::get('company_id');
//        return Excel::download(new UsersExport, 'users.xlsx');
        return (new UsersExport($company_id))->download('users.xlsx');

    }

    public function getImport($id = ''  , Request $request){

        Excel::import(new UsersImport, request()->file('imported-file'));           
        return back();
        
    }

}
