<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use App\Models\Services;
use App\Models\ServiceProviders;

use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Services>
 */
class ServiceFactory extends Factory
{
    protected $model = Services::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $providerIds = ServiceProviders::pluck('id')->toArray();
        return [
            'ServiceName' => $this->faker->word,
            'Description' => $this->faker->sentence,
            'ProviderId' => $this->faker->randomElement($providerIds),
            'Price' => $this->faker->randomDecimal(10, 2),            //
        ];
    }
}
