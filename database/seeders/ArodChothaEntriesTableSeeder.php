<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArodChothaEntriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('arod_chotha_entries')->delete();
        
        \DB::table('arod_chotha_entries')->insert(array (
            0 => 
            array (
                'id' => 3,
                'purchase_id' => 2,
                'sales_qty' => 2.0,
                'sales_weight' => 100.0,
                'sales_rate' => 125.0,
                'created_at' => '2023-12-11 08:02:59',
                'updated_at' => '2023-12-11 08:02:59',
            ),
            1 => 
            array (
                'id' => 4,
                'purchase_id' => 2,
                'sales_qty' => 5.0,
                'sales_weight' => 250.0,
                'sales_rate' => 124.5,
                'created_at' => '2023-12-11 08:03:23',
                'updated_at' => '2023-12-11 08:03:23',
            ),
            2 => 
            array (
                'id' => 5,
                'purchase_id' => 2,
                'sales_qty' => 3.0,
                'sales_weight' => 150.0,
                'sales_rate' => 125.0,
                'created_at' => '2023-12-11 08:03:54',
                'updated_at' => '2023-12-11 08:03:54',
            ),
        ));
        
        
    }
}