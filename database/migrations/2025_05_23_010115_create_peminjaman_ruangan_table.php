<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman_ruangan', function (Blueprint $table) {
            $table->id('peminjaman_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('ruangan_id')->constrained('ruangan', 'ruangan_id')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->integer('durasi_pinjam'); // dalam satuan JP
            $table->dateTime('waktu_selesai');
            $table->text('keperluan');
            $table->enum('status', ['menunggu','disetujui','dibatalkan','ditolak','selesai']); // menunggu, disetujui, ditolak, selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_ruangan');
    }
};
