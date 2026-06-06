<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'path_gambar',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
