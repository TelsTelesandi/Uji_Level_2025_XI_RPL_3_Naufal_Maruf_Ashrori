<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    protected $table = 'ruangan';
    protected $primaryKey = 'ruangan_id';

    protected $fillable = [
        'nama_ruangan', 'lokasi', 'kapasitas', 'status', 'file_gambar',
    ];

    public function peminjaman_ruangan()
    {
        return $this->hasMany(PeminjamanRuangan::class, 'ruangan_id', 'ruangan_id');
    }

    public function pengajuan_pembalian()
    {
        return $this->hasMany(PengembalianRuangan::class, 'pengajuan_pengembalian_id', 'pengajuan_pengembalian_id');
    }
}
