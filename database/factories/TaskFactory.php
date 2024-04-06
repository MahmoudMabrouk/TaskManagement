<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employee = Employee::inRandomOrder()->first();
        $manager = $employee->manager;

        return [
            'employee_id' => $employee->id,
            'manager_id' => $manager->id,
            'title' => fake()->name(),
            'description' => fake()->text(),
            'status' => fake()->randomElement(['to_do', 'in_progress', 'testing', 'done'])
        ];
    }
}
