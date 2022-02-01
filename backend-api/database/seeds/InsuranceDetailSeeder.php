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
            'insuranceStatus' => 'Rejected',
            'insuranceDescription'=>'Foto yang diberikan kurang jelas',
        ]);
        InsuranceDetail::create([
            'insuranceID'=>'2',
            'filePDF'=>'NULL',
            'claimedInsuranceDate'=>'2021/02/28',
            'insuranceStatus' => 'Approved',
            'insuranceDescription'=>'Silahkan tunjukkan file PDF kepada pihak bengkel',
        ]);
        InsuranceDetail::create([
            'insuranceID'=>'3',
            'filePDF'=>'NULL',
            'claimedInsuranceDate'=>'2021/02/28',
            'insuranceStatus' => 'on progress',
            'insuranceDescription'=>'NULL',
        ]);
        InsuranceDetail::create([
            'insuranceID'=>'4',
            'filePDF'=>'NULL',
            'claimedInsuranceDate'=>'2022/03/01',
            'insuranceStatus' => 'on progress',
            'insuranceDescription'=>'NULL',
        ]);
        InsuranceDetail::create([
            'insuranceID'=>'5',
            'filePDF'=>'NULL',
            'claimedInsuranceDate'=>'2022/03/02',
            'insuranceStatus' => 'on progress',
            'insuranceDescription'=>'NULL',
        ]);
        InsuranceDetail::create([
            'insuranceID'=>'6',
            'filePDF'=>'NULL',
            'claimedInsuranceDate'=>'2022/03/03',
            'insuranceStatus' => 'on progress',
            'insuranceDescription'=>'NULL',
        ]);
    }
}
