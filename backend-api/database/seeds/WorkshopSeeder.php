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
            'workshopName' => 'Daihatsu',
            'workshopAddress' => 'Jl. Sukamaju blok C no. 12',
            'workshopPhoneNumber' => '024928492',
            'workshopEmail'=>'sukamaju@gmail.com',
            'workshopDescription'=>'pilihan bengkel terbaik',
            'rating'=>'5',
            'workshopLogo'=>'',
            'city'=>'Jakarta',
            'district'=>'Jakarta Barat',
            'province'=>'DKI Jakarta',
            'latitude'=>'-6.091547',
            'longitude'=>'106.744798',
            'statusHr'=>'buka',
            'status24hr'=>''
        ]);

        Workshop::create([
            'userID'=>'2',
            'workshopName' => 'Honda',
            'workshopAddress' => 'Jl. Sukamaju blok C no. 12',
            'workshopPhoneNumber' => '23214928492',
            'workshopEmail'=>'sukamaju232@gmail.com',
            'workshopDescription'=>'pilihan bengkel terbaik',
            'rating'=>'4',
            'workshopLogo'=>'',
            'city'=>'Banten',
            'district'=>'Tangerang',
            'province'=>'DKI Jakarta',
            'latitude'=>'-6.080771',
            'longitude'=>'106.695535',
            'statusHr'=>'tutup',
            'status24hr'=>''
        ]);

        Workshop::create([
            'userID'=>'3',
            'workshopName' => 'Toyota',
            'workshopAddress' => 'Jl. Sukamaju blok C no. 12',
            'workshopPhoneNumber' => '23214928492',
            'workshopEmail'=>'sukamaju232@gmail.com',
            'workshopDescription'=>'pilihan bengkel terbaik',
            'rating'=>'2',
            'workshopLogo'=>'',
            'city'=>'Banten',
            'district'=>'Tangerang',
            'province'=>'DKI Jakarta',
            'latitude'=>'-6.080771',
            'longitude'=>'106.695535',
            'statusHr'=>'buka',
            'status24hr'=>''
        ]);

        Workshop::create([
            'userID'=>'4',
            'workshopName' => 'Honda',
            'workshopAddress' => 'Jl. Sukamundur blok TT no. 36',
            'workshopPhoneNumber' => '23214928492',
            'workshopEmail'=>'sukamundur123@gmail.com',
            'workshopDescription'=>'Bengkel terbaik disekitar sini',
            'rating'=>'4.5',
            'workshopLogo'=>'',
            'city'=>'Tangerang',
            'district'=>'Tangerang',
            'province'=>'Banten',
            'latitude'=>'-6.080771',
            'longitude'=>'106.695535',
            'statusHr'=>'Buka',
            'status24hr'=>''
        ]);
    }
}
