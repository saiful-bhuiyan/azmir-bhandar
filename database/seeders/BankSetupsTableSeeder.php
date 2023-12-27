<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BankSetupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bank_setups')->delete();
        
        \DB::table('bank_setups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'bank_name' => 'ইসলামী ব্যাংক লিঃ',
                'account_name' => 'ওমর ফয়সাল',
                'account_no' => '2050777020508081147',
                'shakha' => 'ফেনী',
                'status' => 1,
                'created_at' => '2023-12-21 12:20:28',
                'updated_at' => '2023-12-21 12:20:28',
            ),
        ));
        
        
    }
}