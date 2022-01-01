<?php

use Illuminate\Database\Seeder;
use App\Review;
class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Review::Create(
            [
            'scheduleID'=>'1',
            'userName'=>'kenny',
            'reviewDate'=>'2022-10-22',
            'description'=>'sampah anjing',
            'rating'=>'5'
            ]
        );
    }
}
