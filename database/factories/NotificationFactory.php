<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition()
    {
        return [
            'content' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['unread', 'read']),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
