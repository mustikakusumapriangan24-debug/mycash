<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Hubungan dengan data siswa.
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Hubungan dengan data bendahara.
     */
    public function bendahara()
    {
        return $this->hasOne(Bendahara::class, 'user_id');
    }

    /**
     * Hubungan dengan data wali kelas.
     */
    public function waliKelas()
    {
        return $this->hasOne(WaliKelas::class, 'user_id');
    }

    /**
     * Hubungan dengan notifikasi.
     * Satu user dapat memiliki banyak notifikasi.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
