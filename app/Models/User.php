<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // peran dibedakan dari domain email
    const DOMAIN_MANAJER = '@manajer.koperasi';
    const DOMAIN_ADMIN = '@admin.koperasi';

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // mengembalikan 'manajer', 'admin', atau null kalau domain email tidak dikenal
    public static function peranDariEmail($email)
    {
        $email = strtolower(trim($email));

        if (str_ends_with($email, self::DOMAIN_MANAJER)) {
            return 'manajer';
        }

        if (str_ends_with($email, self::DOMAIN_ADMIN)) {
            return 'admin';
        }

        return null;
    }

    public function peran()
    {
        return self::peranDariEmail($this->email);
    }

    public function adalahManajer()
    {
        return $this->peran() == 'manajer';
    }

    public function adalahAdmin()
    {
        return $this->peran() == 'admin';
    }

    // tulisan peran untuk ditampilkan di menu
    public function namaPeran()
    {
        return ucfirst($this->peran() ?? 'tamu');
    }
}