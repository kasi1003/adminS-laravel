<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rows;
use App\Models\GraveSections;

class RowsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all grave sections
        $sections = GraveSections::all();

        // Loop through each section
        foreach ($sections as $section) {
            // Determine the number of rows for the section
            $numRows = $section->Rows;

            // Generate rows for the section
            for ($i = 1; $i <= $numRows; $i++) {
                // Get the last digit of the section code
                $lastDigit = substr($section->SectionCode, -1);

                // Define row data
                $rowData = [
                    'CemeteryID' => $section->CemeteryID,
                    'SectionCode' => $section->SectionCode,
                    'RowID' => 'R_' . $section->CemeteryID . '_' . $lastDigit . '_' . $i,
                    // You can generate AvailableGraves and TotalGraves as needed
                    'AvailableGraves' => rand(1, 10), // Generate random number of available graves
                    'TotalGraves' => rand(10, 20), // Generate random number of total graves
                ];

                // Insert data into the rows table
                Rows::create($rowData);
            }
        }
    }
}
