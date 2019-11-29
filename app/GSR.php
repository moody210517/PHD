<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GSR extends Model
{
    //
    protected $table = 'tbl_s_gsr';

    public function getName()
    {
        return 'first_name'; // db column name
    }
    
}
