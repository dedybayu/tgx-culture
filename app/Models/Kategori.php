<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'm_kategori';
    protected $primaryKey = 'kategori_id';

    protected $fillable = [
        'nama_kategori',
        'path_gambar',
    ];

    public function katalog(): HasMany
    {
        return $this->hasMany(Katalog::class, 'kategori_id', 'kategori_id');
    }
}
