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
                'fullName' => "Admin daihasu",
                'displayName'=>'daihatsi',
                'email' => 'daihatsu@gmail.com',
                'password' => bcrypt('daihatsumobil'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '085813600655',
                'address'=> 'jl kabupaten indah no 50',
                'role' => '2',
                'profilePicture'=>'test.jpg',
                'tokenChat'=>'1s12e12r2'
            ]
        );
        User::Create(
            [
                'fullName' => "admin HONDA",
                'displayName'=>'HONDA',
                'email' => 'Honda@gmail.com',
                'password' => bcrypt('hondamobil'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '086237237',
                'address'=> 'jl kedoya indah no 50',
                'role' => '2',
                'profilePicture'=>'test.jpg',
                'tokenChat'=>'2d232d2222'
            ]
        );
        User::Create(
            [
                'fullName' => "admin Toyota",
                'displayName'=>'Toyota',
                'email' => 'toyota@gmail.com',
                'password' => bcrypt('toyotamobil'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '0826326',
                'address'=> 'jl maju indah no 50',
                'role' => '2',
                'profilePicture'=>'test.jpg',
                'tokenChat'=>'12f2123f21'
            ]
        );
        User::Create(
            [
                'fullName' => "kenny",
                'displayName'=>'kennyganteng',
                'email' => 'kenny@gmail.com',
                'password' => bcrypt('kennyganteng'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '085813600655',
                'address'=> 'jl puri indah no 50',
                'role' => '1',
                'profilePicture'=>'',
                'tokenChat'=>'12f31344gf'
            ]
        );
    }
}
