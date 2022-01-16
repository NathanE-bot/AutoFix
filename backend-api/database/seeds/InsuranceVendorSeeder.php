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
            'insuranceName'=>'alianz',
            'phoneNumber' => '085231624',
        ]);
    }
}
