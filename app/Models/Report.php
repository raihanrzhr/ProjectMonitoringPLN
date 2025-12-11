<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $primaryKey = 'laporan_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'unit_id',
        'peminjaman_id',
        'user_id_pelapor',
        'tgl_kejadian',
        'lokasi_penggunaan',
        'deskripsi_kerusakan',
        'status_laporan',
        'no_ba',
        'keperluan_anggaran',
    ];

    // Relasi ke Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
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

    // Relasi polymorphic ke Images
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
