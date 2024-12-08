<?php

namespace Database\Factories;

use App\Models\CleaningTask;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CleaningPlanFactory extends Factory
{

    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'cleaning_task_id' => CleaningTask::factory(),
            'user_id' => User::factory(),
        ];
    }
}
