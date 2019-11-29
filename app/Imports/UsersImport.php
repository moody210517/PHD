<?php

namespace App\Imports;

use App\Users;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        //return new $this->model($row); 
        $check = Users::where('email_address', $row[1])->get();
        if(!$check->first()){
            return new Users([
                'email_address' => $row[1],
                'user_password' => $row[2],
                'user_type_id' => $row[3],
                'doctor_id' => $row[4],
                'supervisor_id' => $row[5],
                'company_id' => $row[6],
                'first_name' => $row[7],
                'last_name' => $row[8],
                'office_num' => $row[9],
                'home_num' => $row[10],
                'mobile_num' => $row[11],
                'fax_num' => $row[12],
                'home_email' => $row[13],
                'work_email' => $row[14],
                'date_of_birth' => $row[15],
                'user_height' => $row[16],
                'billing_id' => $row[17],
                'shipping_id' => $row[18]
            ]);
        }else{
            return null;
        }

    }


    
    
    
}
