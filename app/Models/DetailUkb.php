<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailUkb extends Model
{
    protected $table = 'detail_ukb';
    protected $primaryKey = 'unit_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'unit_id',
        'jenis_ukb',
        'type',
        'panjang_kabel_m',
        'kabel',
        'volume',
    ];

    // Relasi ke UnitMobile
    public function unitMobile()
    {
        return $this->belongsTo(UnitMobile::class, 'unit_id', 'unit_id');
    }
}
