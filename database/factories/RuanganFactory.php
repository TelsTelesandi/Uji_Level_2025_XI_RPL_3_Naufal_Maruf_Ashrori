<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ruangan>
 */
class RuanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_ruangan' => 'Ruang ' . fake()->randomLetter() . fake()->randomDigit(),
            'lokasi' => fake()->randomElement(['Gedung A - Lantai 1', 'Gedung B - Lantai 1', 'Gedung A - Lantai 2', 'Gedung B - Lantai 2', 'Gedung A - Lantai 3', 'Gedung B - Lantai 3']),
            'kapasitas' => fake()->numberBetween(15, 50),
        ];
    }
}
