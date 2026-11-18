<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'kode_kelas',
        'tahun_ajaran',
        'keterangan',
        'id_wali_kelas',
        'tipe_periode',
        'nominal_standar',
        'status',
    ];

    protected $attributes = [
        'status' => 'aktif',
    ];

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(WaliKelas::class, 'id_wali_kelas');
    }

    public function bendahara(): HasMany
    {
        return $this->hasMany(Bendahara::class, 'kelas_id');
    }
}
