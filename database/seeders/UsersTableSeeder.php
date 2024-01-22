<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Saiful Islam',
                'email' => 'supersaiful18@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$JtmE17YZbbrkaoLMmHE0mObTK3S0LRTPuPaIu7MZ8fY0jIMLQL/kW',
                'remember_token' => NULL,
                'created_at' => '2023-12-21 05:25:31',
                'updated_at' => '2023-12-21 05:25:31',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Faisal Mazumder',
                'email' => 'faisalmazumder2120@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$Lo/7i.AbrMTzTTFCKMDzpOlmSYA/K/4xD9N0W3tbHFyZ6VAQKTz36',
                'remember_token' => NULL,
                'created_at' => '2023-12-23 11:55:21',
                'updated_at' => '2023-12-23 11:55:21',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Nahid',
                'email' => '00nahid51@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$oGa3OodQNjvlcMbIfkQNYOxFXj7ftykxyLRos7kA2ox5G77e5rzpe',
                'remember_token' => NULL,
                'created_at' => '2023-12-23 12:17:30',
                'updated_at' => '2023-12-23 12:17:30',
            ),
        ));
        
        
    }
}