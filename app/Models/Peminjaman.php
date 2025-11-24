<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'peminjaman_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'unit_id',
        'user_id_pemohon',
        'tgl_mobilisasi',
        'tgl_event_mulai',
        'tgl_event_selesai',
        'tgl_demobilisasi',
        'kegiatan',
        'Tamu_VIP',
        'lokasi_tujuan',
        'up3_id',
        'status_peminjaman',
        'keterangan',
    ];

    // Relasi ke Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    // Relasi ke User
    public function userPemohon()
    {
        return $this->belongsTo(User::class, 'user_id_pemohon', 'id');
    }
}
