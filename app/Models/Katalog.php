<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Katalog extends Model
{
    use HasFactory;

    protected $table = 't_katalog';
    protected $primaryKey = 'katalog_id';

    protected $fillable = [
        'kategori_id',
        'user_id',
        'judul',
        'deskripsi',
        'pencipta',
        'subjek',
        'penerbit',
        'kontribusi',
        'tanggal',
        'tipe',
        'format',
        'identitas',
        'sumber',
        'bahasa',
        'hubungan',
        'lokasi',
        'hak_cipta',
    ];

    protected $casts = [
        // tanggal is now a string
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function mediaKatalogs(): HasMany
    {
        return $this->hasMany(MediaKatalog::class, 'katalog_id', 'katalog_id');
    }

    public function getPathGambarAttribute()
    {
        $firstGambar = $this->mediaKatalogs()->where('type', 'image')->first();
        return $firstGambar ? $firstGambar->path_link : null;
    }
}
