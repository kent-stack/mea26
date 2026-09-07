<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'username',
    'email',
    'password',
    'is_admin',
    'is_superadmin',
    'full_name',
    'place_of_birth',
    'date_of_birth',
    'photo_3x4',
    'school_origin',
    'gender',
    'address',
    'whatsapp_number',
    'telegram_number',
    'agama',
    'kewarganegaraan',
    'status_pernikahan',
    'provinsi',
    'kabupaten_kota',
    'jalan',
    'dusun',
    'kecamatan',
    'kelurahan_desa',
    'rt',
    'rw',
    'kode_pos',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_superadmin' => 'boolean',
        ];
    }
}
