<?php

use Illuminate\Database\Seeder;
use App\Insurance;
class InsuranceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Insurance::create([
            'userID'=>'6',
            'vendorInsuranceID'=>'1',
            'insuredName'=>'Kenny Ongko',
            'phoneNumberClaimer' => '085231624',
            'emailClaimer'=>'kennyongkowinata@gmail.com',
            'addressClaimer'=>'villa jambil jakarta barat',
            'carTypeAndBrand' => 'suzuki R3 GAT',
            'chassisNumber'=>'123214123',
            'polisNumber'=>'284712849442',
            'licensePlateNumber' => 'B 1459 BOX',
            'driverName'=>'Kenny Ongko',
            'driverSpeed'=>'50KM/H',
            'driverRelation' => 'anak',
            'incidentLocation'=>'Jalan tol subang KM 25',
            'vehicleDescription'=>'Berwana hitam ',
            'incidentDate' => '2022/01/23',
            'incidentTime'=>'17:20:00',
            'taxiOnlineStatus'=>'no',
            'workshopType' => 'SUZUKI',
            'chronology'=>'Sya mengantuk dan nabrak di tol',
            'incidentStatus'=>'no',
            'incidentStatusDescription' => 'NULL',
            'submiteDate' => '2022/01/24',
        ]);
    }
}
