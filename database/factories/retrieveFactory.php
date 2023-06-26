<?php

namespace Database\Factories;

use App\Models\retrieve;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\retrieve>
 */
class retrieveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */protected $model = retrieve::class;
    public function definition(): array
    {
        return [
            //
            'Firstname' => $this->faker->firstName(),
            'Lastname' => $this->faker->lastName(),
            'Section' => $this->faker->numberBetween(1, 4) . $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'timeIn' => $this->faker->time(),
            'timeOut' => $this->faker->time(),
            'status' => "present"
        ];
    }
}