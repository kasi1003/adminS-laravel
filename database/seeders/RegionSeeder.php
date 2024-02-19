<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            ['name' => 'Zambezi'],
            ['name' => 'Kavango West'],
            ['name' => 'Kavango East'],
            ['name' => 'Kunene'],
            ['name' => 'Omusati'],
            ['name' => 'Ohangwena'],
            ['name' => 'Oshana'],
            ['name' => 'Oshikoto'],
            ['name' => 'Omaheke'],
            ['name' => 'Otjozondjupa'],
            ['name' => 'Erongo'],
            ['name' => 'Khomas'],
            ['name' => 'Hardap'],
            ['name' => 'Karas'],
        ];

        // Insert data into regions table
        DB::table('regions')->insert($regions);
    }
}
