<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Feedback;

class FeedbackFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(4, User::count()),
            'shop_id' => $this->faker->numberBetween(1,2),
            'rating' => $this->faker->numberBetween(1,5),
            'comment' => $this->faker->realText(100),
        ];
    }
}
