<?php

use Illuminate\Database\Seeder;
use App\InsuranceVendor;
class InsuranceVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InsuranceVendor::create([
            'userID'=>'5',
            'insuranceName'=>'Alienz',
            'phoneNumber' => '085231624',
            'email'=>'Alienz@gmail.com',
            'logo'=>'http://127.0.0.1:8000/storage/avatar/kenny2022-01-24_14-24-226.jpg',
            'address'=>'Jl Mawar Indah Block M2 no 10'
        ]);
        InsuranceVendor::create([
            'userID'=>'8',
            'insuranceName'=>'preben',
            'phoneNumber' => '085231624',
            'email'=>'alianz@gmail.com',
            'logo'=>'http://127.0.0.1:8000/storage/avatar/kenny2022-01-24_14-24-226.jpg',
            'address'=>'Jl Mawar Indah Block M2 no 10'
        ]);
    }
}
