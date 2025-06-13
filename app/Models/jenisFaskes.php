<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisFaskes extends Model
{
    protected $table = 'jenis_faskes';

    protected $fillable = [
        'nama',
    ];

    /**
     * Relasi: Jenis_faskes memiliki banyak Faskes
     */
    public function faskes(): HasMany
    {
        return $this->hasMany(Faskes::class, 'jenis_faskes_id');
    }
}
