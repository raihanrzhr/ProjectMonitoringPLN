<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitMobile extends Model
{
    protected $table = 'unit_mobiles';
    protected $primaryKey = 'unit_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_unit',
        'tipe_peralatan',
        'nopol',
        'merk_kendaraan',
        'tipe_kendaraan',
        'kondisi_kendaraan',
        'status',
        'lokasi',
        'catatan',
        'tgl_service_terakhir',
        'status_bpkb',
        'status_stnk',
        'pajak_tahunan',
        'pajak_5tahunan',
        'status_kir',
        'masa_berlaku_kir',
        'dokumentasi',
    ];

    // Relasi ke DetailDeteksi
    public function detailDeteksi()
    {
        return $this->hasOne(DetailDeteksi::class, 'unit_id', 'unit_id');
    }

    // Relasi ke DetailUkb
    public function detailUkb()
    {
        return $this->hasOne(DetailUkb::class, 'unit_id', 'unit_id');
    }

    // Relasi ke DetailUps
    public function detailUps()
    {
        return $this->hasOne(DetailUps::class, 'unit_id', 'unit_id');
    }

    // Relasi ke Peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'unit_id', 'unit_id');
    }

    // Relasi ke LaporanKerusakan
    public function laporanKerusakan()
    {
        return $this->hasMany(LaporanKerusakan::class, 'unit_id', 'unit_id');
    }

    // Relasi ke Perbaikan
    public function perbaikan()
    {
        return $this->hasMany(Perbaikan::class, 'unit_id', 'unit_id');
    }
}
