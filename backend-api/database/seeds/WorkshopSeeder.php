<?php

use Illuminate\Database\Seeder;
use App\Workshop;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Workshop::create([
            'userID'=>'1',
            'workshopName' => 'daihana',
            'workshopAddress' => 'Jl. Sukamaju blok C no. 12',
            'workshopPhoneNumber' => '024928492',
            'workshopEmail'=>'daihana@gmail.com',
            'workshopDescription'=>'Memberikan Berbagai Jenis Servis dengan harga yang murah dan Cepat , merupakan pilihan bengkel terbaik dengan harga termurah',
            'rating'=>'5',
            'workshopLogo'=>'',
            'city'=>'Jakarta',
            'district'=>'Jakarta Barat',
            'province'=>'DKI Jakarta',
            'latitude'=>'-6.091547',
            'longitude'=>'106.744798',
            'statusHr'=>'buka',
            'status24hr'=>'1'
        ]);

        Workshop::create([
            'userID'=>'2',
            'workshopName' => 'honsda',
            'workshopAddress' => 'Jl. Sukamaju blok C no. 12',
            'workshopPhoneNumber' => '23214928492',
            'workshopEmail'=>'honsda@gmail.com',
            'workshopDescription'=>'Memberikan Berbagai Jenis Servis dengan harga yang murah dan Cepat , merupakan pilihan bengkel terbaik dengan harga termurah',
            'rating'=>'5',
            'workshopLogo'=>'',
            'city'=>'Banten',
            'district'=>'Tangerang',
            'province'=>'DKI Jakarta',
            'latitude'=>'-6.080771',
            'longitude'=>'106.695535',
            'statusHr'=>'tutup',
            'status24hr'=>'0'
        ]);

        Workshop::create([
            'userID'=>'3',
            'workshopName' => 'tota',
            'workshopAddress' => 'Jl. Sukamaju blok C no. 12',
            'workshopPhoneNumber' => '23214928492',
            'workshopEmail'=>'tota@gmail.com',
            'workshopDescription'=>'Memberikan Berbagai Jenis Servis dengan harga yang murah dan Cepat , merupakan pilihan bengkel terbaik dengan harga termurah',
            'rating'=>'5',
            'workshopLogo'=>'',
            'city'=>'Banten',
            'district'=>'Tangerang',
            'province'=>'DKI Jakarta',
            'latitude'=>'-6.080771',
            'longitude'=>'106.695535',
            'statusHr'=>'buka',
            'status24hr'=>'1'
        ]);

        Workshop::create([
            'userID'=>'4',
            'workshopName' => 'BWW',
            'workshopAddress' => 'Jl. Sukamundur blok TT no. 36',
            'workshopPhoneNumber' => '23214928492',
            'workshopEmail'=>'BWW@gmail.com',
            'workshopDescription'=>'Memberikan Berbagai Jenis Servis dengan harga yang murah dan Cepat , merupakan pilihan bengkel terbaik dengan harga termurah',
            'rating'=>'5',
            'workshopLogo'=>'',
            'city'=>'Tangerang',
            'district'=>'Tangerang',
            'province'=>'Banten',
            'latitude'=>'-6.080771',
            'longitude'=>'106.695535',
            'statusHr'=>'Buka',
            'status24hr'=>'1'
        ]);
    }
}
