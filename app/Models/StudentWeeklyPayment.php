<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentWeeklyPayment extends Model
{
    protected $fillable = [
        'student_id',
        'transaction_id',
        'school_year',
        'week_number',
        'amount',
        'paid_at',
    ];

    protected $casts = [
        'school_year' => 'integer',
        'week_number' => 'integer',
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
