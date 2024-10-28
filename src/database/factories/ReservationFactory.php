<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Reservation;

class ReservationFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(4, User::count()),
            'shop_id' => $this->faker->numberBetween(1,2),
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'number' => $this->faker->numberBetween(1,10),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
