<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services;
use App\Models\ServiceProviders;

class ServiceFactory extends Factory
{
    protected $model = Services::class;

    // Define a template of service names
    protected $serviceNames = [
        'Flowers',
        'Transportation',
        'Legal Assistance',
        'Catering',
        'General Assistance',
        'Professional Stand-ins',
        // Add more service names as needed
    ];

    public function definition()
    {
        // Get all service provider IDs
        $providerIds = ServiceProviders::pluck('id')->toArray();

        // Define an array to hold the service data
        $services = [];

        // Loop through each service provider ID
        foreach ($providerIds as $providerId) {
            // Generate a random number of services between 1 and 5
            $numServices = $this->faker->numberBetween(1, 5);

            // Generate services for the current provider
            for ($i = 0; $i < $numServices; $i++) {
                $services[] = [
                    'ServiceName' => $this->faker->randomElement($this->serviceNames), // Randomly select a service name from the template
                    'Description' => $this->faker->sentence,
                    'ProviderId' => $providerId,
                    'Price' => $this->faker->randomFloat(2, 0, 1000), // Random price between 0 and 1000
                ];
            }
        }

        return $services;
    }
}


