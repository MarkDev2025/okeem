<?php

namespace Database\Factories;

use App\Models\Okeemien;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OkeemienFactory extends Factory
{
    protected $model = Okeemien::class;

    public function definition()
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
