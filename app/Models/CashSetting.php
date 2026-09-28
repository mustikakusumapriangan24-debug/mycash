<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashSetting extends Model
{
    use HasFactory;

    protected $table = 'cash_settings';

    protected $fillable = [
        'amount',
        'effective_from',
        'description',
    ];

    protected $casts = [
        'effective_from' => 'date',
        'amount' => 'decimal:2',
    ];
}