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
            'workshopName' => 'My Workshop',
            'workshopAddress' => 'Jl. Sukamaju blok C no. 12',
            'workshopPhoneNumber' => '024928492',
            'workshopEmail'=>'sukamaju@gmail.com',
            'workshopDescription'=>'pilihan bengkel terbaik'
        ]);

        Workshop::create([
            'userID'=>'2',
            'workshopName' => 'you Workshop',
            'workshopAddress' => 'Jl. Sukamaju blok C no. 12',
            'workshopPhoneNumber' => '23214928492',
            'workshopEmail'=>'sukamaju232@gmail.com',
            'workshopDescription'=>'pilihan bengkel terbaik'
        ]);
    }
}
