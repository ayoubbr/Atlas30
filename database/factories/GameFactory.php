<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Stadium;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'start_date' => $this->faker->date(),
            'start_hour' => $this->faker->time(),
            'home_team_id' => Team::inRandomOrder()->first()->id,
            'away_team_id' => Team::inRandomOrder()->first()->id,
            'stadium_id' => Stadium::inRandomOrder()->first()->id,
            'home_team_goals' => $this->faker->numberBetween(0, 5),
            'away_team_goals' => $this->faker->numberBetween(0, 5),
            'image' => 'https://cdn.vectorstock.com/i/500p/58/35/soccer-bannertemplate-football-banner-vs-vector-53655835.jpg',
            'status' => $this->faker->randomElement(['scheduled', 'live', 'finished']),
        ];
    }
}
