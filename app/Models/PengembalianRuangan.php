<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengembalianRuangan extends Model
{
    protected $table = 'pengembalian_ruangan';

    protected $guarded = ['pengembalian_id'];

    protected $primaryKey = 'pengembalian_id';

    public function peminjaman()
    {
        return $this->belongsTo(PeminjamanRuangan::class, 'peminjaman_id', 'peminjaman_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
