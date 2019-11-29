<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitPurpose extends Model
{
    //
    protected $table = 'tbl_visit_purpose';

    protected $fillable = [
        'id','title', 'type'
    ];


}
