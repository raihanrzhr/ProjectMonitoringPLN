<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitArchive extends Model
{
    use HasFactory;

    protected $table = 'unit_archives';
    
    // Set primary key
    protected $primaryKey = 'unit_id';

    // PENTING: Matikan auto-increment karena kita meng-copy ID dari tabel Units
    public $incrementing = false;

    // Tentukan tipe data ID (sesuai migration unsignedInteger)
    protected $keyType = 'int';

    // Gunakan guarded kosong agar semua kolom bisa diisi (mass assignment) saat proses copy data
    protected $guarded = [];

    // Casting tipe data (opsional, disesuaikan dengan kebutuhan)
    protected $casts = [
        'tgl_service_terakhir' => 'date',
        'pajak_tahunan' => 'date',
        'pajak_5tahunan' => 'date',
        'masa_berlaku_kir' => 'date',
        'status_bpkb' => 'boolean',
        'status_stnk' => 'boolean',
        'status_kir' => 'boolean',
        'archived_at' => 'datetime',
    ];
}