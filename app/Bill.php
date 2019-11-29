<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    //
    protected $table = 'tbl_user_billing';

    public function getName()
    {
        return 'first_name'; // db column name
    }
    
}
