<?php

use Illuminate\Database\Seeder;
use App\WorkshopService;
class WorkshopServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkshopService::create([
            'workshopDetailID'=>'1',
            'servicType'=>'Servis Berkala',
            'servicDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'2',
            'servicType'=>'Servis Berkala',
            'servicDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'3',
            'servicType'=>'Servis Berkala',
            'servicDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'4',
            'servicType'=>'Servis Berkala',
            'servicDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'5',
            'servicType'=>'Servis Berkala',
            'servicDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'6',
            'servicType'=>'Servis Berkala',
            'servicDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'7',
            'servicType'=>'Servis Berkala',
            'servicDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'1',
            'servicType'=>'Servis umum',
            'servicDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'2',
            'servicType'=>'Servis umum',
            'servicDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'3',
            'servicType'=>'Servis umum',
            'servicDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'4',
            'servicType'=>'Servis umum',
            'servicDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'5',
            'servicType'=>'Servis umum',
            'servicDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'6',
            'servicType'=>'Servis umum',
            'servicDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'7',
            'servicType'=>'Servis umum',
            'servicDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
    }
}
