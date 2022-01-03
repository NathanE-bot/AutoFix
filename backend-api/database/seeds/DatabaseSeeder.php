<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(WorkshopSeeder::class);
        $this->call(OperationalWorkshopSeeder::class);
        $this->call(WorkshopDetailSeeder::class);
        $this->call(WorkshopServiceSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(InsuranceVendorSeeder::class);
        $this->call(ScheduleDetailSeeder::class);
    }
}
