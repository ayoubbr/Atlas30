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

        $homeTeam = Team::inRandomOrder()->first();
        $awayTeam = Team::where('id', '!=', $homeTeam->id)->inRandomOrder()->first();

        return [
            'start_date' => $this->faker->dateTimeBetween('-1 week', '+2 months')->format('Y-m-d'),
            'start_hour' => $this->faker->time('H:i'),
            'home_team_id' => $homeTeam->id,
            'away_team_id' => $awayTeam->id,
            'stadium_id' => Stadium::inRandomOrder()->first()->id,
            'home_team_goals' => $this->faker->numberBetween(0, 5),
            'away_team_goals' => $this->faker->numberBetween(0, 5),
            'image' => 'Atlas30_logo.png',
            'status' => $this->faker->randomElement(['upcoming', 'live', 'completed', 'canceled', 'postponed']),
        ];
    }
}
