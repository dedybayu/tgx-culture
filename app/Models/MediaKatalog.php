<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaKatalog extends Model
{
    use HasFactory;

    protected $table = 't_media_katalog';
    protected $primaryKey = 'media_katalog_id';

    protected $fillable = [
        'katalog_id',
        'type',
        'path_link',
    ];

    public function katalog(): BelongsTo
    {
        return $this->belongsTo(Katalog::class, 'katalog_id', 'katalog_id');
    }
}
