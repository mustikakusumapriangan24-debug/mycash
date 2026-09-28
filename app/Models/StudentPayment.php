<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
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
}