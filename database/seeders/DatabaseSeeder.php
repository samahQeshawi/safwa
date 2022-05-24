<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UserSeeder::class);
        $this->call(StatusesSeeder::class);
        $this->call(PaymentMethodSeeder::class);
    }
}