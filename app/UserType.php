<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    //
    protected $table = 'tbl_user_type';

    public function getName()
    {
        return 'first_name'; // db column name
    }
    
}
