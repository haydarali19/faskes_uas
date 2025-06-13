<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'nama',
    ];

    /**
     * Relasi: Kategori memiliki banyak Faskes
     */
    public function faskes(): HasMany
    {
        return $this->hasMany(Faskes::class, 'kategori_id');
    }
}
