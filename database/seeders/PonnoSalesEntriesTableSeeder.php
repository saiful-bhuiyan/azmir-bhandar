<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PonnoSalesEntriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ponno_sales_entries')->delete();
        
        \DB::table('ponno_sales_entries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sales_invoice' => 1000,
                'purchase_id' => 2,
                'sales_qty' => 1.0,
                'sales_weight' => 50.0,
                'sales_rate' => 60.0,
                'labour' => 10.0,
                'other' => 5.0,
                'mohajon_commission' => 35.0,
                'kreta_commission' => 15.0,
                'created_at' => '2023-11-01 14:46:07',
                'updated_at' => '2023-11-01 14:46:07',
            ),
            1 => 
            array (
                'id' => 2,
                'sales_invoice' => 1001,
                'purchase_id' => 2,
                'sales_qty' => 2.0,
                'sales_weight' => 100.0,
                'sales_rate' => 50.0,
                'labour' => 20.0,
                'other' => 0.0,
                'mohajon_commission' => 70.0,
                'kreta_commission' => 30.0,
                'created_at' => '2023-11-08 15:27:09',
                'updated_at' => '2023-11-08 15:27:09',
            ),
        ));
        
        
    }
}