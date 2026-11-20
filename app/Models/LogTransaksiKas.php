<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogTransaksiKas extends Model
{
    protected $table = 'log_transaksi_kas';

    protected $fillable = [
        'transaksi_kas_id',
        'no_nota',
        'kelas_id',
        'user_id',
        'aktivitas',
        'data_lama',
        'data_baru',
        'keterangan',
        'ip_address',
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
}
