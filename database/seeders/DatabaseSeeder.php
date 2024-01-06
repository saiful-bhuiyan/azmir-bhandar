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
        $this->call(KretaSetupsTableSeeder::class);
        $this->call(MohajonSetupsTableSeeder::class);
        $this->call(OtherJomaKhorocSetupsTableSeeder::class);
        $this->call(BankSetupsTableSeeder::class);
        $this->call(OtherJomaKhorocEntriesTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
    }
}
