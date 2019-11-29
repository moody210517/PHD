<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oximeter extends Model
{
    //
    protected $table = 'tbl_s_pulse_oximeter';
    public function getName()
    {
        return 'first_name'; // db column name
    }
    
}
