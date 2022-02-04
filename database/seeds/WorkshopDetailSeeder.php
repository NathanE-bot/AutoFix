<?php

use Illuminate\Database\Seeder;
use App\WorkshopDetail;
class WorkshopDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        WorkshopDetail::create([
            'workshopID'=>'1',
            'carModel'=>'RoCV',
            'CarType'=>'RoCV CVT'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'1',
            'carModel'=>'RoCV',
            'CarType'=>'RoCV SVT'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'1',
            'carModel'=>'RoCV',
            'CarType'=>'RoCV MVT'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'1',
            'carModel'=>'RoCV',
            'CarType'=>'RoCV AVT'
        ]);

        WorkshopDetail::create([
            'workshopID'=>'1',
            'carModel'=>'Teriasz',
            'CarType'=>'Teriasz 1.5 A'
        ]);

        WorkshopDetail::create([
            'workshopID'=>'1',
            'carModel'=>'Teriasz',
            'CarType'=>'Teriasz 3.5 R'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'1',
            'carModel'=>'Teriasz',
            'CarType'=>'Teriasz 1.5 R'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'1',
            'carModel'=>'Teriasz',
            'CarType'=>'Teriasz 3.5 A'
        ]);
        //2
        WorkshopDetail::create([
            'workshopID'=>'2',
            'carModel'=>'CRZ',
            'CarType'=>'CRZ model S'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'2',
            'carModel'=>'CRZ',
            'CarType'=>'CRZ model Z'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'2',
            'carModel'=>'CRZ',
            'CarType'=>'CRZ model A'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'2',
            'carModel'=>'CRZ',
            'CarType'=>'CRZ model M'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'2',
            'carModel'=>'HRZ',
            'CarType'=>'HRZ Mugern'
        ]);

        WorkshopDetail::create([
            'workshopID'=>'2',
            'carModel'=>'HRZ',
            'CarType'=>'HRZ Sport'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'2',
            'carModel'=>'HRZ',
            'CarType'=>'HRZ Auto'
        ]);

        WorkshopDetail::create([
            'workshopID'=>'2',
            'carModel'=>'BRZ',
            'CarType'=>'BRZ sport'
        ]);
        //3
        WorkshopDetail::create([
            'workshopID'=>'3',
            'carModel'=>'camri',
            'CarType'=>'camri special force'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'3',
            'carModel'=>'zupra',
            'CarType'=>'zupra Sport Auto'
        ]);
        //4 - start di 8
        WorkshopDetail::create([
            'workshopID'=>'4',
            'carModel'=>'Jizz',
            'CarType'=>'Jizz RS'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'4',
            'carModel'=>'Jizz',
            'CarType'=>'Jizz Sport'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'4',
            'carModel'=>'Pio',
            'CarType'=>'Pio Satya S M/T'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'4',
            'carModel'=>'Pio',
            'CarType'=>'Pio Satya E M/T'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'4',
            'carModel'=>'Pio',
            'CarType'=>'Pio Satya E CVT'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'4',
            'carModel'=>'Mobilala',
            'CarType'=>'RS 1.5'
        ]);
    }
}
