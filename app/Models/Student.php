<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nis',
        'name',
        'gender',
        'phone',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];
}