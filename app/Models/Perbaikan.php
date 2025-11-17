<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    protected $table = 'perbaikan';
    protected $primaryKey = 'perbaikan_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'laporan_id',
        'unit_id',
        'item_pekerjaan',
        'no_notdin',
        'tgl_notdin',
        'status_acc_ku',
        'tgl_eksekusi',
        'nilai_pekerjaan',
        'keterangan',
    ];

    // Relasi ke LaporanKerusakan
    public function laporanKerusakan()
    {
        return $this->belongsTo(LaporanKerusakan::class, 'laporan_id', 'laporan_id');
    }

    // Relasi ke UnitMobile
    public function unitMobile()
    {
        return $this->belongsTo(UnitMobile::class, 'unit_id', 'unit_id');
    }
}
