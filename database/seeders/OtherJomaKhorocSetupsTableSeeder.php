<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OtherJomaKhorocSetupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('other_joma_khoroc_setups')->delete();
        
        \DB::table('other_joma_khoroc_setups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'আবু আদনান দিহান হাজারী',
                'address' => 'বারাহিপুর',
                'mobile' => '00',
                'status' => 1,
                'created_at' => '2023-12-21 12:10:04',
                'updated_at' => '2023-12-21 12:10:04',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'গদি খরচ',
                'address' => 'নিজ দোকান',
                'mobile' => '00',
                'status' => 1,
                'created_at' => '2023-12-21 12:10:37',
                'updated_at' => '2023-12-21 12:10:37',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'দান খাত',
                'address' => 'নিজ দোকান',
                'mobile' => '00',
                'status' => 1,
                'created_at' => '2023-12-21 12:11:45',
                'updated_at' => '2023-12-21 12:11:45',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'যাকাত খাত',
                'address' => 'নিজ দোকান',
                'mobile' => '00',
                'status' => 1,
                'created_at' => '2023-12-21 12:12:17',
                'updated_at' => '2023-12-21 12:12:17',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'ক্যাশ বাড়তি ও ঘারতি',
                'address' => 'নিজ দোকান',
                'mobile' => '00',
                'status' => 1,
                'created_at' => '2023-12-21 12:15:19',
                'updated_at' => '2023-12-21 12:15:19',
            ),
        ));
        
        
    }
}