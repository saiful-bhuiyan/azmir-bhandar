<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admins')->delete();
        
        \DB::table('admins')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Faisal Mazumder',
                'email' => 'faisalmazumder2120@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$w449unkx7N78JgBE9si0a.E2l0SHY25pG.QeKBgbe8OvjxEuiI702',
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Jahidul Islam',
                'email' => '00nahid51@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$6OGLS1tpNGJemp1ZeYYI9O233umrCVQ0kcrAfOm617eXbhD4H.B5K',
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Saiful Islam',
                'email' => 'supersaiful18@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$SCjXnz0m8/NfebISRO7WvemhMHuAURFJ62SyiMUA2k92RwtLuJNgy',
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}