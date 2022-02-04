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
                'fullName' => "Admin daihana",
                'displayName'=>'daihana',
                'email' => 'daihana@gmail.com',
                'password' => bcrypt('daihanamobil'),
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
                'fullName' => "admin honsda",
                'displayName'=>'honsda',
                'email' => 'honsda@gmail.com',
                'password' => bcrypt('honsdamobil'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '086237237',
                'address'=> 'jl kedoya honsda no 50',
                'role' => '2',
                'profilePicture'=>'',
                'tokenChat'=>'2d232d2222'
            ]
        );
        User::Create(
            [
                'fullName' => "admin tota",
                'displayName'=>'tota',
                'email' => 'tota@gmail.com',
                'password' => bcrypt('totamobil'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '082632612312',
                'address'=> 'jl maju tota no 50',
                'role' => '2',
                'profilePicture'=>'',
                'tokenChat'=>'12f2123f21'
            ]
        );
        User::Create(
            [
                'fullName' => "admin BWW",
                'displayName'=>'BWW',
                'email' => 'BWW@gmail.com',
                'password' => bcrypt('BWWmobil'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '082632621312',
                'address'=> 'jl maju BWW no 50',
                'role' => '2',
                'profilePicture'=>'',
                'tokenChat'=>'32f2453f1'
            ]
        );
        User::Create(
            [
                'fullName' => "Alienz",
                'displayName'=>'Alienz',
                'email' => 'Alienz@gmail.com',
                'password' => bcrypt('AlienzAsuransi'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '085231624',
                'address'=> 'jl puri mall no 50',
                'role' => '3',
                'profilePicture'=>'',
                'tokenChat'=>'ins#2'
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
        User::Create(
            [
                'fullName' => "Prubential",
                'displayName'=>'Prubential',
                'email' => 'Prubential@gmail.com',
                'password' => bcrypt('PrubentialAsuransi'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '085231624',
                'address'=> 'jl puri mall no 50',
                'role' => '3',
                'profilePicture'=>'',
                'tokenChat'=>'ins#1'
            ]
        );
    }
}
