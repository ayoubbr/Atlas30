<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->country,
            'flag' => 'https://flagcdn.com/w320/' . strtolower($this->faker->countryCode) . '.png',
            'code' => strtoupper($this->faker->lexify('???')),
        ];
    }
}
