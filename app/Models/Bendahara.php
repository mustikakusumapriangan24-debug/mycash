<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
