<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'maintenance';
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

    // Relasi ke Maintenance
    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class, 'laporan_id', 'laporan_id');
    }

    // Relasi ke Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }
}
