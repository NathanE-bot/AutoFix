<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::Create(
            [
                'fullName' => "Nathan Engolodoe",
                'displayName'=>'Godlen',
                'email' => 'nathanengolodoe@gmail.com',
                'password' => bcrypt('qweqweqwe'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '085813600655',
                'address'=> 'Resapan Air',
                'role' => '1',
                'profilePicture'=>''
            ]
        );
        factory(\App\User::class, 10)->create();
    }
}
