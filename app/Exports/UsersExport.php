<?php

namespace App\Exports;

use App\Users;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class UsersExport implements FromQuery
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(int $company_id)
    {
        $this->company_id = $company_id;
    }

    public function query()
    {
        return Users::query()->where('company_id', $this->company_id);
        //return Users::where('company_id', $this->company_id);
        // return DB::select( DB::raw("SELECT * FROM tbl_user WHERE company_id = '$this->company_id'") );
    }

}
