<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    //
    protected $table = 'tbl_user';

    protected $fillable = array(  'email_address',
    'user_password',
    'user_type_id',
    'doctor_id',
    'supervisor_id',
    'company_id',
    'first_name',
    'last_name',
    'office_num',
    'home_num',
    'mobile_num',
    'fax_num',
    'home_email',
    'work_email',
    'date_of_birth',
    'user_height',
    'billing_id',
    'shipping_id',
    'emr_ehr_id');  
    public function getName()
    {
        return 'first_name'; // db column name
    }
    
}
