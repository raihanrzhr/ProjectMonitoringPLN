<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKerusakan extends Model
{
    protected $table = 'laporan_kerusakan';
    protected $primaryKey = 'laporan_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'unit_id',
        'peminjaman_id',
        'user_id_pelapor',
        'tgl_kejadian',
        'lokasi_kejadian',
        'deskripsi_kerusakan',
        'status_laporan',
        'no_ba',
        'keperluan_anggaran',
    ];

    // Relasi ke UnitMobile
    public function unitMobile()
    {
        return $this->belongsTo(UnitMobile::class, 'unit_id', 'unit_id');
    }

    // Relasi ke Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'peminjaman_id');
    }

    // Relasi ke User
    public function userPelapor()
    {
        return $this->belongsTo(User::class, 'user_id_pelapor', 'id');
    }
}
