<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Définir l'état par défaut du modèle User.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // 🔒 Génère un mot de passe sécurisé
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indique que l'email ne doit pas être vérifié.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Crée un utilisateur administrateur.
     */
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin1234'), // 🔒 Mot de passe fort
            'role' => 'admin',
        ]);
    }
}
