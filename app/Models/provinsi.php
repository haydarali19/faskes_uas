<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provinsi extends Model
{
    protected $table = 'provinsis';

    protected $fillable = [
        'nama',
        'ibukota',
        'latitude',
        'longitude',
    ];

    /**
     * Relasi: Provinsi memiliki banyak Kabupaten_kota
     */
    public function kabupatenKotas(): HasMany
    {
        return $this->hasMany(Kabkota::class, 'provinsi_id');
    }
}
