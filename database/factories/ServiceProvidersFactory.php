<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ServiceProviders;
use Faker\Generator as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceProviders>
 */
class ServiceProvidersFactory extends Factory
{
    protected $model = ServiceProviders::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'Name' => $this->faker->company,
            'Motto' => $this->faker->sentence,
            'Email' => $this->faker->unique()->safeEmail,
            'ContactNumber' => $this->faker->randomNumber(9, true), // Generate a random 9-digit number            'TotalBurials' => $this->faker->numberBetween(0, 100),
            'SuccessfulBurials' => $this->faker->numberBetween(0, 100),
            'UnsuccessfulBurials' => $this->faker->numberBetween(0, 100),
            //
        ];
    }
}
