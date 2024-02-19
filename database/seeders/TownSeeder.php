<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $towns = [
            ['region_id' => 1, 'name' => 'Katima Mulilo'],
            ['region_id' => 2, 'name' => 'Nkurenkuru'],
            ['region_id' => 3, 'name' => 'Rundu'],
            ['region_id' => 4, 'name' => 'Khorixas'],
            ['region_id' => 4, 'name' => 'Opuwo'],
            ['region_id' => 5, 'name' => 'Okahao'],
            ['region_id' => 5, 'name' => 'Oshikuku'],
            ['region_id' => 5, 'name' => 'Outapi'],
            ['region_id' => 5, 'name' => 'Ruacana'],
            ['region_id' => 6, 'name' => 'Eenhana'],
            ['region_id' => 6, 'name' => 'Helao Nafidi'],
            ['region_id' => 7, 'name' => 'Oshakati'],
            ['region_id' => 7, 'name' => 'Ondangwa'],
            ['region_id' => 7, 'name' => 'Ongwediva'],
            ['region_id' => 8, 'name' => 'Omuthiya'],
            ['region_id' => 8, 'name' => 'Oniipa'],
            ['region_id' => 9, 'name' => 'Gobabis'],
            ['region_id' => 10, 'name' => 'Otavi'],
            ['region_id' => 10, 'name' => 'Okakarara'],
            ['region_id' => 11, 'name' => 'Arandis'],
            ['region_id' => 11, 'name' => 'Karibib'],
            ['region_id' => 11, 'name' => 'Usakos'],
            ['region_id' => 12, 'name' => 'Windhoek'],
            ['region_id' => 13, 'name' => 'Aranos'],
            ['region_id' => 13, 'name' => 'Rehoboth'],
        ];

        // Insert data into towns table
        DB::table('towns')->insert($towns);
    }
}
