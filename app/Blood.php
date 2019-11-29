<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blood extends Model
{
    //
    protected $table = 'tbl_s_blood_pressure';

    public function getName()
    {
        return 'first_name'; // db column name
    }
    
}
