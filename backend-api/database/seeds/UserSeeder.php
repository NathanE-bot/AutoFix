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
                'address'=> 'jl kabupaten daihasu no 50',
                'role' => '2',
                'profilePicture'=>'',
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
                'address'=> 'jl kedoya HONDA no 50',
                'role' => '2',
                'profilePicture'=>'',
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
                'phoneNumber' => '082632612312',
                'address'=> 'jl maju Toyota no 50',
                'role' => '2',
                'profilePicture'=>'',
                'tokenChat'=>'12f2123f21'
            ]
        );
        User::Create(
            [
                'fullName' => "admin BMW",
                'displayName'=>'BMW',
                'email' => 'BMW@gmail.com',
                'password' => bcrypt('BMWmobil'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '082632621312',
                'address'=> 'jl maju BMW no 50',
                'role' => '2',
                'profilePicture'=>'',
                'tokenChat'=>'32f2453f1'
            ]
        );
        User::Create(
            [
                'fullName' => "Alianz",
                'displayName'=>'Alianz',
                'email' => 'Alianz@gmail.com',
                'password' => bcrypt('AlianzAsuransi'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '085231624',
                'address'=> 'jl puri mall no 50',
                'role' => '3',
                'profilePicture'=>'',
                'tokenChat'=>'12f31344gf'
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
                'tokenChat'=>'2321f23w12'
            ]
        );
        User::Create(
            [
                'fullName' => "Nathan Engolodoe",
                'displayName'=>'gugugugu',
                'email' => 'nathanengolodoe@gmail.com',
                'password' => bcrypt('qwdqwdqwd'),
                'DoB' => Carbon::parse('2000-10-24'),
                'phoneNumber' => '087808769902',
                'address'=> 'RESAPAN AER',
                'role' => '1',
                'profilePicture'=>'',
                'tokenChat'=>'499023ufie2'
            ]
        );
    }
}
