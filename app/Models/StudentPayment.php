<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentPayment extends Model
{
    public const MONTHLY_FEE = 10000;

    protected $fillable = [
        'student_id',
        'transaction_id',
        'payment_month',
        'amount',
        'paid_at',
    ];

    protected $casts = [
        'payment_month' => 'date',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}