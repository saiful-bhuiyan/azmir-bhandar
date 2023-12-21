<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
        $this->call(PonnoSalesInfosTableSeeder::class);
        $this->call(PonnoSalesEntriesTableSeeder::class);
        $this->call(ArodChothaEntriesTableSeeder::class);
        $this->call(CheckBookPageSetupsTableSeeder::class);
    }
}
