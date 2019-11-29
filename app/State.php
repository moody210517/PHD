<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    //
    protected $table = 'tbl_state';

    public function getName()
    {
        return 'first_name'; // db column name
    }
    
}
