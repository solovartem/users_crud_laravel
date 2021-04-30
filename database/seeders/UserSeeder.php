<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name'       => 'Super Admin', 
        	'email'      => 'superadmin@superadmin.com',
            'address'    =>  'India',
            'image'     => 'dummy-profile.jpg'
        ];
        $modelName = new User();
        foreach ($data  as $key => $value) {
            $modelName->$key = $value;
        }
        $modelName->save();

        $data = [
            'name'         => 'Admin', 
        	'email'        => 'admin@superadmin.com',
            'address'      =>  'India',
            'image'       => 'dummy-profile.jpg'
        ];
        $modelName = new User();
        foreach ($data  as $key => $value) {
            $modelName->$key = $value;
        }
        $modelName->save();
    }
}
