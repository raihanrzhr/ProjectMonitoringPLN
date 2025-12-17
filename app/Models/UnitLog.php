<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitLog extends Model
{
    protected $table = 'unit_logs';

    protected $fillable = [
        'unit_id',
        'user_id',
        'kategori_histori',
        'keterangan',
        'date_time',
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];

    /**
     * Relasi ke Unit
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
