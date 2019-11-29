<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $table = 'tbl_city';

    public function getName()
    {
        return 'city_name'; // db column name
    }
    
}
