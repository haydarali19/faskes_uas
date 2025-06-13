<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kabkota extends Model
{
    protected $table = 'kabkotas';

    protected $fillable = [
        'nama',
        'latitude',
        'longitude',
        'provinsi_id',
    ];

    /**
     * Relasi: Kabupaten_kota milik Provinsi
     */
    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    /**
     * Relasi: Kabupaten_kota memiliki banyak Faskes
     */
    public function faskes(): HasMany
    {
        return $this->hasMany(Faskes::class, 'kabkota_id');
    }
}
