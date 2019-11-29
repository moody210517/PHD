<?php

use Illuminate\Database\Seeder;
use App\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        UserType::create([
            'auto_num' => '1',
            'user_type_name' => 'Office Manager',
            'role' => 'OM'
        ]);

        UserType::create([
            'auto_num' => '2',
            'user_type_name' => 'Doctor',
            'role' => 'DO'
        ]);
        UserType::create([
            'auto_num' => '3',
            'user_type_name' => 'Nurce',
            'role' => 'NU'
        ]);
        UserType::create([
            'auto_num' => '4',
            'user_type_name' => 'Patient',
            'role' => 'PT'
        ]);
        UserType::create([
            'auto_num' => '5',
            'user_type_name' => 'PA',
            'role' => 'PA'
        ]);

    }
}
