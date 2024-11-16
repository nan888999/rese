<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;

class FeedbacksTableSeeder extends Seeder
{
    public function run()
    {
        Feedback::factory()->count(10)->create();
    }
}
