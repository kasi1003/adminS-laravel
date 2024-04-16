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
            ['region_id' => 2, 'name' => 'Rundu'],
            ['region_id' => 2, 'name' => 'Divundu'],
            ['region_id' => 3, 'name' => 'Khorixas'],
            ['region_id' => 3, 'name' => 'Opuwo'],
            ['region_id' => 4, 'name' => 'Okahao'],
            ['region_id' => 4, 'name' => 'Oshikuku'],
            ['region_id' => 4, 'name' => 'Outapi'],
            ['region_id' => 4, 'name' => 'Ruacana'],
            ['region_id' => 5, 'name' => 'Eenhana'],
            ['region_id' => 5, 'name' => 'Helao Nafidi'],
            ['region_id' => 6, 'name' => 'Oshakati'],
            ['region_id' => 6, 'name' => 'Ondangwa'],
            ['region_id' => 6, 'name' => 'Ongwediva'],
            ['region_id' => 7, 'name' => 'Omuthiya'],
            ['region_id' => 7, 'name' => 'Tsumeb'],
            ['region_id' => 8, 'name' => 'Gobabis'],
            ['region_id' => 8, 'name' => 'Otjinene'],
            ['region_id' => 9, 'name' => 'Otavi'],
            ['region_id' => 9, 'name' => 'Grootfontein'],
            ['region_id' => 9, 'name' => 'Okahandja'],
            ['region_id' => 9, 'name' => 'Otjiwarongo'],
            ['region_id' => 9, 'name' => 'Okakarara'],
            ['region_id' => 10, 'name' => 'Arandis'],
            ['region_id' => 10, 'name' => 'Karibib'],
            ['region_id' => 10, 'name' => 'Swakopmund'],
            ['region_id' => 11, 'name' => 'Windhoek'],
            ['region_id' => 12, 'name' => 'Rehoboth'],
            ['region_id' => 12, 'name' => 'Mariental'],
            ['region_id' => 13, 'name' => 'Keetmanshoop'],
            ['region_id' => 13, 'name' => 'Luderitz'],
        ];

        // Insert data into towns table
        DB::table('towns')->insert($towns);
    }
}
