<?php

namespace Database\Factories;

use App\Models\Cemeteries;
use Illuminate\Database\Eloquent\Factories\Factory;

class CemeteriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cemeteries::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'CemeteryName' => $this->faker->name,
            'Town' => $this->faker->numberBetween(1, 25), // Select a random number between 1 and 25
            'NumberOfSections' => $this->faker->numberBetween(1, 10),
            'TotalGraves' => $this->faker->numberBetween(10, 50),
            'AvailableGraves' => $this->faker->numberBetween(5, 25),
            'SvgMap' => null, // Set SvgMap to null
        ];
    }
}
