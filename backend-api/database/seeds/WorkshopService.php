<?php

use Illuminate\Database\Seeder;
use App\WorkshopService;
class WorkshopService extends Seeder
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
            'servicType'=>'Sevis Berkala',
            'servisDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'2',
            'servicType'=>'Sevis Berkala',
            'servisDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'3',
            'servicType'=>'Sevis Berkala',
            'servisDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'4',
            'servicType'=>'Sevis Berkala',
            'servisDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'5',
            'servicType'=>'Sevis Berkala',
            'servisDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'6',
            'servicType'=>'Sevis Berkala',
            'servisDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'7',
            'servicType'=>'Sevis Berkala',
            'servisDetail'=>'1.000 KM',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'1',
            'servicType'=>'Sevis umum',
            'servisDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'2',
            'servicType'=>'Sevis umum',
            'servisDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'3',
            'servicType'=>'Sevis umum',
            'servisDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'4',
            'servicType'=>'Sevis umum',
            'servisDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'5',
            'servicType'=>'Sevis umum',
            'servisDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'6',
            'servicType'=>'Sevis umum',
            'servisDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
        WorkshopService::create([
            'workshopDetailID'=>'7',
            'servicType'=>'Sevis umum',
            'servisDetail'=>'ganti Oli',
            'price'=>'2000000',
            'time'=>'2'
        ]);
    }
}
