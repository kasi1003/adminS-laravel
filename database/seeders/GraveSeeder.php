<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Graves;
use App\Models\Rows;

class GraveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all rows
        $rows = Rows::all();

        // Loop through each row
        foreach ($rows as $row) {
            // Determine the number of total and available graves for the row
            $totalGraves = $row->TotalGraves;
            $availableGraves = $row->AvailableGraves;

            // Generate graves for the row based on available graves
            for ($i = 1; $i <= $totalGraves; $i++) {
                // Define grave data
                $graveData = [
                    'CemeteryID' => $row->CemeteryID,
                    'SectionCode' => $row->SectionCode,
                    'RowID' => $row->RowID,
                    'GraveNum' => $i, // Incrementing grave number within the row
                    'GraveStatus' => $i <= $availableGraves ? null : 1, // 1 for occupied, null for available
                    'BuriedPersonsName' => null,
                    'DateOfBirth' => null,
                    'DateOfDeath' => null,
                    'DeathCode' => null,
                ];

                // If the grave is occupied, generate random data for BuriedPersonsName, DateOfBirth, DateOfDeath, and DeathCode
                if ($graveData['GraveStatus'] === 1) {
                    $graveData['BuriedPersonsName'] = $this->generateRandomName();
                    $graveData['DateOfBirth'] = $this->generateRandomDateOfBirth();
                    $graveData['DateOfDeath'] = $this->generateRandomDateOfDeath();
                    $graveData['DeathCode'] = $this->generateRandomDeathCode();
                }

                // Insert data into the graves table
                Graves::create($graveData);
            }
        }
    }

    /**
     * Generate a random name.
     *
     * @return string
     */
    private function generateRandomName()
    {
        $names = ['John Doe', 'Jane Doe', 'Alice Smith', 'Bob Johnson', 'Emily Brown'];
        return $names[array_rand($names)];
    }

    /**
     * Generate a random date of birth.
     *
     * @return string
     */
    private function generateRandomDateOfBirth()
    {
        return now()->subYears(rand(18, 90))->subDays(rand(0, 365))->toDateString();
    }

    /**
     * Generate a random date of death.
     *
     * @return string
     */
    private function generateRandomDateOfDeath()
    {
        return now()->subYears(rand(1, 100))->subDays(rand(0, 365))->toDateString();
    }

    /**
     * Generate a random death code.
     *
     * @return string
     */
    private function generateRandomDeathCode()
    {
        return str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
    }
}
