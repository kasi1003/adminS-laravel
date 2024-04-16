<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Services;
use App\Models\ServiceProviders;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Specify the number of services you want to create (e.g., 10)
        $numServices = 10;
        
        // Get all service provider IDs
        $providerIds = ServiceProviders::pluck('id')->toArray();

        // Create services for each provider
        foreach ($providerIds as $providerId) {
            Services::factory()->count($numServices)->create([
                'ProviderId' => $providerId,
            ]);
        }
    }
}



