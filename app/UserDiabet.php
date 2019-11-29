<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDiabet extends Model
{
    //
    protected $table = 'tbl_user_diabet';

    protected $fillable = array(  'user_id',
    'waist',
    'bpmeds',
    'glucose',
    'vegetable',
    'family');  

    public function getName()
    {
        return 'waist'; // db column name
    }
    
}
