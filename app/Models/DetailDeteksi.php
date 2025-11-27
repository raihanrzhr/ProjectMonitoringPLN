<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailDeteksi extends Model
{
    protected $table = 'detail_deteksi';
    protected $primaryKey = 'unit_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'unit_id',
        'fitur',
        'type',
    ];

    // Relasi ke Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }
}
