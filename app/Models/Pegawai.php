<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'telepon',
        'jabatan',
        'departemen',
        'tanggal_masuk',
        'alamat',
        'status',
    ];
}