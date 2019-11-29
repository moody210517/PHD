<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $table = 'tbl_messages';

    public function getName()
    {
        return 'first_name'; // db column name
    }
    
}
