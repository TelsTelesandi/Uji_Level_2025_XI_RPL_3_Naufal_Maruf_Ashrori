<?php

namespace Database\Seeders;

use App\Models\PeminjamanRuangan;
use App\Models\Ruangan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            "username" => "admin123",
            "id_card" => "232410104",
            "nama_lengkap" => "Admin",
            "password" => bcrypt("password"),
            "jenis_pengguna" => "siswa",
            "role" => "admin"
        ]);
        User::create([
            "username" => "user123",
            "id_card" => "232410105",
            "nama_lengkap" => "User",
            "password" => bcrypt("password"),
            "jenis_pengguna" => "siswa",
            "role" => "user"
        ]);

        User::factory(20)->create();
        Ruangan::factory(15)->create();
        // PeminjamanRuangan::factory(40)->create();
    }
}
