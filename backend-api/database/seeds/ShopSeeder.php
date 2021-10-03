<?php

use Illuminate\Database\Seeder;
use App\Shop;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Shop::Create([
            'shopName' => "Bambang Yamaha",
            'shopAddress' => 'barito 3',
            'LogoURL' => 'helo.jpg',
            'operationalHour' => '',
            'gallery' => 'galer',
            'contactPhoneNumber' => '01823712378',
            'contactEmailAddress' => 'BambangY@gmail.com',
        ]);
    }
}
