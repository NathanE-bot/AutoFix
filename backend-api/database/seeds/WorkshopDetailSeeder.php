<?php

use Illuminate\Database\Seeder;

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
            'carModel'=>'Rocy',
            'CarType'=>'Rocy CVT'
        ]);

        WorkshopDetail::create([
            'workshopID'=>'1',
            'carModel'=>'Terios',
            'CarType'=>'Terios 1.5 R'
        ]);
        //2
        WorkshopDetail::create([
            'workshopID'=>'2',
            'carModel'=>'CRV',
            'CarType'=>'CRV model S'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'2',
            'carModel'=>'HRV',
            'CarType'=>'HRV Mugern'
        ]);

        WorkshopDetail::create([
            'workshopID'=>'2',
            'carModel'=>'BRV',
            'CarType'=>'BRV sport'
        ]);
        //3
        WorkshopDetail::create([
            'workshopID'=>'3',
            'carModel'=>'camry',
            'CarType'=>'camry special force'
        ]);
        WorkshopDetail::create([
            'workshopID'=>'3',
            'carModel'=>'supra',
            'CarType'=>'supra webseries'
        ]);

    }
}
