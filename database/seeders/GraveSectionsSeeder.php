<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GraveSections;

class GraveSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define grave section data
        $graveSections = [
            [
                'CemeteryID' => 1,
                'SectionCode' => 'S_1_1',
                'Rows' => 3,
                'SectionType' => 'General',
                'SectionSvg' => null,
            ],
            [
                'CemeteryID' => 1,
                'SectionCode' => 'S_1_2',
                'Rows' => 5,
                'SectionType' => 'Family',
                'SectionSvg' => null,
            ],
            [
                'CemeteryID' => 1,
                'SectionCode' => 'S_1_3',
                'Rows' => 2,
                'SectionType' => 'Christian',
                'SectionSvg' => null,
            ],
            [
                'CemeteryID' => 2,
                'SectionCode' => 'S_2_1',
                'Rows' => 2,
                'SectionType' => 'Family',
                'SectionSvg' => null,
            ],
            [
                'CemeteryID' => 2,
                'SectionCode' => 'S_2_2',
                'Rows' => 5,
                'SectionType' => 'general',
                'SectionSvg' => null,
            ],
            [
                'CemeteryID' => 3,
                'SectionCode' => 'S_3_1',
                'Rows' => 6,
                'SectionType' => 'General',
                'SectionSvg' => null,
            ],
            [
                'CemeteryID' => 3,
                'SectionCode' => 'S_3_2',
                'Rows' => 2,
                'SectionType' => 'traditional',
                'SectionSvg' => null,
            ],
            [
                'CemeteryID' => 4,
                'SectionCode' => 'S_4_1',
                'Rows' => 4,
                'SectionType' => 'traditional',
                'SectionSvg' => null,
            ],
            [
                'CemeteryID' => 4,
                'SectionCode' => 'S_4_2',
                'Rows' => 2,
                'SectionType' => 'general',
                'SectionSvg' => null,
            ],
            [
                'CemeteryID' => 4,
                'SectionCode' => 'S_4_3',
                'Rows' => 3,
                'SectionType' => 'veterans',
                'SectionSvg' => null,
            ],
            
            // Add more grave section data as needed
        ];

        // Insert data into the grave_sections table
        foreach ($graveSections as $graveSection) {
            GraveSections::create($graveSection);
        }
    }
}
