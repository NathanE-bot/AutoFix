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
            'name' => 'My Workshop',
            'address' => 'Jl. Sukamaju blok C no. 12',
            'description' => 'Maju jaya jaya jaya ......',
        ]);

        Workshop::create([
            'name' => 'My Workshop 2',
            'address' => 'Jl. Sukamaju blok C no. 12',
            'description' => 'Maju jaya jaya jaya jaya ......',
        ]);
    }
}
