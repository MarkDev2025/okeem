<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tuteur>
 */
class TuteurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prenom' => $this->faker->firstName,
            'nom' => $this->faker->lastName,
            'slug' => Str::slug($this->faker->firstName . ' ' . $this->faker->lastName, '-'),
            'email' => $this->faker->unique()->safeEmail,
            'telephone' => $this->faker->phoneNumber
        ];
    }
}
