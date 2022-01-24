<?php

use Illuminate\Database\Seeder;
use App\InsuranceDetail;
class InsuranceDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InsuranceDetail::create([
            'insuranceID'=>'1',
            'filePDF'=>'NULL',
            'claimedInsuranceDate'=>'2021/01/02',
            'insuranceStatus' => 'on progress',
            'insuranceDescription'=>'NULL',
        ]);
    }
}
