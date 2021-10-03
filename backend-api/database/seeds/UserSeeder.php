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
        User::Create([
            'name' => "developer",
            'email' => 'developer@gmail.com',
            'password' => bcrypt('qweqweqwe'),
            'DoB' => Carbon::parse('2000-10-11')
        ]);
    }
}
