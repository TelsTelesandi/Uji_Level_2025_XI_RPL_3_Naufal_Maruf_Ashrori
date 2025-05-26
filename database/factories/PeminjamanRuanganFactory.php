<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PeminjamanRuangan>
 */
class PeminjamanRuanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggal = fake()->dateTimeBetween('-10 days', 'now');
        $waktuMulai = Carbon::instance($tanggal)->setTime(fake()->numberBetween(7, 14), 0);
        $durasiJP = fake()->numberBetween(1, 3);
        $waktuSelesai = (clone $waktuMulai)->addMinutes($durasiJP * 45);

        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->user_id ?? 1,
            'ruangan_id' => \App\Models\Ruangan::inRandomOrder()->first()->ruangan_id ?? 1,
            'tanggal' => $tanggal->format('Y-m-d'),
            'waktu_mulai' => $waktuMulai,
            'durasi_pinjam' => $durasiJP,
            'waktu_selesai' => $waktuSelesai,
            'status' => fake()->randomElement(['menunggu', 'disetujui', 'ditolak', 'selesai']),
        ];
    }
}
