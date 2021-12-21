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
                'fullName' => "admin",
                'displayName'=>'adminganteng',
                'email' => 'admin123@gmail.com',
                'password' => bcrypt('admin123'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '085813600655',
                'address'=> 'jl kabupaten indah no 50',
                'role' => '1',
                'profilePicture'=>''
            ]
        );
        User::Create(
            [
                'fullName' => "kenny",
                'displayName'=>'kennyganteng',
                'email' => 'kenny@gmail.com',
                'password' => bcrypt('kennyganteng'),
                'DoB' => Carbon::parse('2000-10-11'),
                'phoneNumber' => '086237237',
                'address'=> 'jl kedoya indah no 50',
                'role' => '1',
                'profilePicture'=>''
            ]
        );
    }
}
