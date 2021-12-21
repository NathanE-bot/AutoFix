<?php

use Illuminate\Database\Seeder;
use App\Operationalworkshop;
class OperationalWorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operationalworkshop::create([
            'workshopID'=>'1',
            'operationlaDate'=>'2021-12-22',
            'operationalOpenHour' => '08:40:20',
            'operationalCloseHour' => '15:40:20',
        ]);
        Operationalworkshop::create([
            'workshopID'=>'2',
            'operationlaDate'=>'2021-12-22',
            'operationalOpenHour' => '08:40:20',
            'operationalCloseHour' => '00:58:20',
        ]);
    }
}
