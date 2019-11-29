<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllocationVisitForm extends Model
{
    //

    protected $table = 'tbl_allocation_visit_form';

    protected $fillable = [
        'id','tester_id', 'patient_id', 'symptoms', 'disease', 'treatment', 'visit_purpose', 'daily_activity'
    ];

}
