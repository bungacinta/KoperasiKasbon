<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    protected $table = 'simpanan';

    protected $fillable = [
        'anggota_id',
        'user_id',
        'jenis',
        'jumlah',
        'tanggal',
    ];

    const JENIS = ['pokok', 'wajib', 'sukarela'];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // admin atau manajer yang menginput
    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function nomorNota()
    {
        return 'SMP-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}