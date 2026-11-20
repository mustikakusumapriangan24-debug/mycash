<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'bendahara_id',
        'type',
        'amount',
        'category',
        'description',
        'receipt_path',
    ];

    public function bendahara(): BelongsTo
    {
        return $this->belongsTo(Bendahara::class, 'bendahara_id');
    }

    public function studentPayments(): HasMany
    {
        return $this->hasMany(StudentPayment::class, 'transaction_id');
    }

    public function weeklyPayments(): HasMany
    {
        return $this->hasMany(StudentWeeklyPayment::class, 'transaction_id');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(LogTransaksiKas::class, 'transaksi_kas_id');
    }
}
