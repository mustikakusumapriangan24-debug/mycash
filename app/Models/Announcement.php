<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'user_id',
        'judul',
        'isi',
        'template',
        'prioritas',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(AnnouncementRecipient::class, 'pengumuman_id');
    }
}
