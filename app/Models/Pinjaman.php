<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';

    protected $fillable = [
        'anggota_id',
        'user_id',
        'jumlah',
        'keperluan',
        'tanggal',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function nomorNota()
    {
        return 'PNJ-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}