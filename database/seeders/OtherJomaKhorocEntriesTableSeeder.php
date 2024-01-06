<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OtherJomaKhorocEntriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('other_joma_khoroc_entries')->delete();
        
        \DB::table('other_joma_khoroc_entries')->insert(array (
            0 => 
            array (
                'id' => 100,
                'other_id' => 6,
                'bank_setup_id' => NULL,
                'check_id' => NULL,
                'type' => 2,
                'marfot' => 'নাহিদ',
                'taka' => 3000.0,
                'payment_by' => 1,
                'entry_date' => '2024-01-02',
                'created_at' => '2024-01-02 13:45:37',
                'updated_at' => '2024-01-02 15:41:09',
            ),
            1 => 
            array (
                'id' => 101,
                'other_id' => 8,
                'bank_setup_id' => NULL,
                'check_id' => NULL,
                'type' => 2,
                'marfot' => 'নাহিদ',
                'taka' => 5000.0,
                'payment_by' => 1,
                'entry_date' => '2024-01-02',
                'created_at' => '2024-01-02 15:50:03',
                'updated_at' => '2024-01-02 15:50:03',
            ),
            2 => 
            array (
                'id' => 102,
                'other_id' => 2,
                'bank_setup_id' => NULL,
                'check_id' => NULL,
                'type' => 2,
                'marfot' => 'নাহিদ',
                'taka' => 4495.0,
                'payment_by' => 1,
                'entry_date' => '2024-01-02',
                'created_at' => '2024-01-02 16:09:07',
                'updated_at' => '2024-01-02 16:09:07',
            ),
            3 => 
            array (
                'id' => 103,
                'other_id' => 2,
                'bank_setup_id' => NULL,
                'check_id' => NULL,
                'type' => 2,
                'marfot' => 'নাহিদ',
                'taka' => 236.0,
                'payment_by' => 1,
                'entry_date' => '2024-01-02',
                'created_at' => '2024-01-03 13:32:02',
                'updated_at' => '2024-01-03 13:36:10',
            ),
            4 => 
            array (
                'id' => 104,
                'other_id' => 6,
                'bank_setup_id' => NULL,
                'check_id' => NULL,
                'type' => 2,
                'marfot' => 'নাহিদ',
                'taka' => 2000.0,
                'payment_by' => 1,
                'entry_date' => '2024-01-03',
                'created_at' => '2024-01-03 13:46:56',
                'updated_at' => '2024-01-03 13:46:56',
            ),
            5 => 
            array (
                'id' => 105,
                'other_id' => 2,
                'bank_setup_id' => NULL,
                'check_id' => NULL,
                'type' => 2,
                'marfot' => 'ফয়সাল',
                'taka' => 1058.0,
                'payment_by' => 1,
                'entry_date' => '2024-01-03',
                'created_at' => '2024-01-03 13:47:52',
                'updated_at' => '2024-01-03 13:52:20',
            ),
        ));
        
        
    }
}