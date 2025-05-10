<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Game;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'game_id' => Game::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'payment_id' => Payment::inRandomOrder()->first()->id,
            'price' => $this->faker->numberBetween(20, 150),
            'place_number' => $this->faker->unique()->numberBetween(1, 500),
            'status' => $this->faker->randomElement(['sold', 'paid', 'canceled', 'used'])
        ];
    }
}
