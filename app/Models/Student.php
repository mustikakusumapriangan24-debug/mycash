<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use SoftDeletes;

    protected $table = 'students';

    protected $fillable = [
        'user_id',
        'nis',
        'name',
        'gender',
        'phone',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    /**
     * Akun login milik siswa.
     * Setiap siswa terhubung dengan satu akun User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}