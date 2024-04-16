<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            RegionSeeder::class,
            TownSeeder::class,
            CemeteriesSeeder::class,
            GraveSectionsSeeder::class,
            RowsSeeder::class,
            GraveSeeder::class,
            ServiceProvidersSeeder::class,
            //ServiceSeeder::class,
        ]);
    }
}
