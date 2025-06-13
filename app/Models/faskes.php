<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faskes extends Model
{
    protected $table = 'faskes';

    protected $fillable = [
        'nama',
        'nama_pengelola',
        'alamat',
        'website',
        'email',
        'rating',
        'latitude',
        'longitude',
        'kabkota_id',
        'jenis_faskes_id',
        'kategori_id',
    ];

    /**
     * Relasi: Faskes milik Kabupaten_kota
     */
    public function kabupatenKota(): BelongsTo
    {
        return $this->belongsTo(Kabkota::class, 'kabkota_id');
    }

    /**
     * Relasi: Faskes milik Jenis_faskes
     */
    public function jenisFaskes(): BelongsTo
    {
        return $this->belongsTo(JenisFaskes::class, 'jenis_faskes_id');
    }

    /**
     * Relasi: Faskes milik Kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
