<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengembalian_ruangan', function (Blueprint $table) {
            $table->id('pengembalian_id');
            $table->foreignId("peminjaman_id")->constrained('peminjaman_ruangan', 'peminjaman_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->enum('kondisi_ruangan', ['baik','kotor','rusak_ringan','rusak_sedang','rusak_berat']);
            $table->enum('status', ['belum_disetujui', 'disetujui'])->default('belum_disetujui');
            $table->text('catatan')->nullable();
            $table->dateTime('tanggal_pengajuan');
            $table->dateTime('tanggal_disetujui')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian_ruangan');
    }
};
