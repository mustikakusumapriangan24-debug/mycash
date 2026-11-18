<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'bendahara_id',
        'type',
        'amount',
        'category',
        'description',
    ];

    public function bendahara(): BelongsTo
    {
        return $this->belongsTo(Bendahara::class, 'bendahara_id');
    }
}
