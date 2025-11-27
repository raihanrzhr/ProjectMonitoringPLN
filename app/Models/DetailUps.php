<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailUps extends Model
{
    protected $table = 'detail_ups';
    protected $primaryKey = 'unit_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'unit_id',
        'kapasitas_kva',
        'jenis_ups',
        'batt_merk',
        'batt_jumlah',
        'batt_kapasitas',
        'model_no_seri',
    ];

    // Relasi ke Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }
}
