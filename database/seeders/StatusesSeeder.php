<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Statuses')->truncate();
        DB::table('Statuses')->insert(array (
            0 => 
            array (
                'id'=>1,
                'format' => 'sms',
                'status' => 'sent',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 => 
            array (
                'id'=>2,
                'format' => 'sms',
                'status' => 'received',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>3,
                'format' => 'sms',
                'status' => 'failed',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>4,
                'format' => 'sms',
                'status' => 'read',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>5,
                'format' => 'push_notification',
                'status' => 'sent',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>6,
                'format' => 'push_notification',
                'status' => 'received',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>7,
                'format' => 'push_notification',
                'status' => 'failed',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>8,
                'format' => 'push_notification',
                'status' => 'read',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>9,
                'format' => 'email',
                'status' => 'sent',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>10,
                'format' => 'email',
                'status' => 'received',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>11,
                'format' => 'email',
                'status' => 'failed',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>12,
                'format' => 'email',
                'status' => 'read',
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));

    }
}
