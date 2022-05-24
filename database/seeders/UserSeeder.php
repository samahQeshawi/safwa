<?php

use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Seeding the Userfactory
        // create 10 users with just one line
        //factory(User::class, 10)->create();
    }
}
