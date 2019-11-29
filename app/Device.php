<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //
    protected $table = 'tbl_device';

    public function getName()
    {
        return 'first_name'; // db column name
    }
    
}
