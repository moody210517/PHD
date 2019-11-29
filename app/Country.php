<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $table = 'tbl_country';

    public function getName()
    {
        return 'first_name'; // db column name
    }
    
}
