<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnouncementRecipient extends Model
{
    protected $table = 'pengumuman_penerima';

    protected $fillable = [
        'user_id',
        'dibaca_at',
    ];

    protected $casts = [
        'dibaca_at' => 'datetime',
    ];

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class, 'pengumuman_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
