<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * 'Cash', 'Wallet', 'Mastercard','Visa','Visa Electron','RuPay','Maestro','Contactless'
     */
    public function run()
    {
        DB::table('payment_methods')->truncate();
        DB::table('payment_methods')->insert(array (
            0 => 
            array (
                'id'=>1,
                'name' => 'Cash',
                'image_file' => NULL,
                'is_active' =>1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            1 => 
            array (
                'id'=>2,
                'name' => 'Wallet',
                'image_file' => NULL,
                'is_active' =>1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>3,
                'name' => 'Mastercard',
                'image_file' => NULL,
                'is_active' =>1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>4,
                'name' => 'Visa',
                'image_file' => NULL,
                'is_active' =>1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>5,
                'name' => 'Visa Electron',
                'image_file' => NULL,
                'is_active' =>1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>6,
                'name' => 'RuPay',
                'image_file' => NULL,
                'is_active' =>1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>7,
                'name' => 'Maestro',
                'image_file' => NULL,
                'is_active' =>1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array (
                'id'=>8,
                'name' => 'Contactless',
                'image_file' => NULL,
                'is_active' =>1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));
    }
}
