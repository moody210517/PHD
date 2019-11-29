<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    //
    protected $table = 'tbl_user_shipping';

    public function getName()
    {
        return 'first_name'; // db column name
    }
    
}
