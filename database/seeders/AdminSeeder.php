<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admins')->delete();
        
        \DB::table('admins')->insert(array (
            0 => 
            array (
                'name' => 'Faisal Mazumder',
                'email' => 'faisalmazumder2120@gmail.com',
                'password' => bcrypt('32472')
            ),
            1 => 
            array (
                'name' => 'Jahidul Islam',
                'email' => '00nahid51@gmail.com',
                'password' => bcrypt('12345678')
            ),
            2 => 
            array (
                'name' => 'Saiful Islam',
                'email' => 'supersaiful18@gmail.com',
                'password' => bcrypt('saiful123')
            ),
        ));
    }
}
