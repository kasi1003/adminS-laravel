<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cemeteries;

class CemeteriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define cemetery data
        $cemeteries = [
            [
                'CemeteryName' => 'Gammams',
                'Town' => '28',
                'NumberOfSections' => 3,
                'TotalGraves' => 20,
                'AvailableGraves' => 15,
                'SvgMap' => null,
            ],
            [
                'CemeteryName' => 'Old Location',
                'Town' => '28',
                'NumberOfSections' => 2,
                'TotalGraves' => 10,
                'AvailableGraves' => 4,
                'SvgMap' => null,
            ],
            [
                'CemeteryName' => 'New road',
                'Town' => '3',
                'NumberOfSections' => 2,
                'TotalGraves' => 10,
                'AvailableGraves' => 4,
                'SvgMap' => null,
            ],
            [
                'CemeteryName' => 'Open field',
                'Town' => '4',
                'NumberOfSections' => 3,
                'TotalGraves' => 30,
                'AvailableGraves' => 27,
                'SvgMap' => null,
            ],
            
        ];

        // Insert data into the cemetery table
        foreach ($cemeteries as $cemetery) {
            Cemeteries::create($cemetery);
        }
    }
}
