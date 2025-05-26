<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanRuangan extends Model
{
    use HasFactory;

     protected $table = 'peminjaman_ruangan';
    protected $primaryKey = 'peminjaman_id';

    protected $fillable = [
        'user_id', 'ruangan_id', 'tanggal', 'waktu_mulai', 'durasi_pinjam', 'waktu_selesai', 'status','keperluan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id', 'ruangan_id');
    }

    public function pengajuan_pengembalian() {
        return $this->hasMany(PengembalianRuangan::class, 'peminjaman_id');
    }

    public function getTanggalFormattedAttribute()
    {
        return Carbon::parse($this->tanggal)->locale('id')->translatedFormat('d F Y');
    }

    public function getWaktuMulaiFormattedAttribute()
    {
        return Carbon::parse($this->waktu_mulai)->locale('id')->translatedFormat('H:i');
    }

    public function getWaktuSelesaiFormattedAttribute()
    {
        return Carbon::parse($this->waktu_selesai)->locale('id')->translatedFormat('H:i');
    }

    public function getCreatedAtFormattedAttribute() {
        return Carbon::parse($this->created_at)->locale('id')->translatedFormat('d F Y');
    }
}
