<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bendahara extends Model
{
    protected $table = 'bendahara';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'nama',
        'nis',
        'no_hp',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'bendahara_id');
    }
}

