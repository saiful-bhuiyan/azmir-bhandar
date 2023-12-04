<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PonnoSalesInfosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ponno_sales_infos')->delete();
        
        \DB::table('ponno_sales_infos')->insert(array (
            0 => 
            array (
                'id' => 1000,
                'sales_type' => 1,
                'kreta_setup_id' => NULL,
                'cash_kreta_address' => 'ফেনী',
                'cash_kreta_name' => 'সাকিব',
                'discount' => 10.0,
                'marfot' => 'নাহিদ',
                'entry_date' => '2023-11-01',
                'created_at' => '2023-11-01 14:46:07',
                'updated_at' => '2023-11-01 14:46:07',
            ),
            1 => 
            array (
                'id' => 1001,
                'sales_type' => 2,
                'kreta_setup_id' => 1,
                'cash_kreta_address' => NULL,
                'cash_kreta_name' => NULL,
                'discount' => 0.0,
                'marfot' => 'নাহিদ',
                'entry_date' => '2023-11-08',
                'created_at' => '2023-11-08 15:27:09',
                'updated_at' => '2023-11-08 15:27:09',
            ),
        ));
        
        
    }
}