<?php

use Illuminate\Database\Seeder;
use App\InsuranceWorkshop;
class InsuranceWorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InsuranceWorkshop::create([
            'vendorInsuranceID'=>'1',
            'insuranceWorkshopName' => 'Bengkel Maju Jaya',
        ]);
        InsuranceWorkshop::create([
            'vendorInsuranceID'=>'1',
            'insuranceWorkshopName' => 'Bengkel Semar',
        ]);
        InsuranceWorkshop::create([
            'vendorInsuranceID'=>'1',
            'insuranceWorkshopName' => 'Bengkel PuraJaya',
        ]);
        InsuranceWorkshop::create([
            'vendorInsuranceID'=>'1',
            'insuranceWorkshopName' => 'Bengkel Sinar Bulan',
        ]);
    }
}
