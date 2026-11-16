<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use App\Models\Simpanan;
use App\Models\Pegawai;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung anggota aktif
        $jumlahAnggotaAktif = Anggota::where('status', 'aktif')->count();

        // Menghitung total simpanan dan pinjaman
        $totalSimpanan = Simpanan::sum('jumlah');
        $totalPinjaman = Pinjaman::sum('jumlah');

        // Menghitung total pegawai
        $totalPegawai = Pegawai::count();

        // Mengambil 5 data simpanan terbaru
        $simpananTerbaru = Simpanan::with('anggota')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // Mengambil 5 data pinjaman terbaru
        $pinjamanTerbaru = Pinjaman::with('anggota')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'jumlahAnggotaAktif',
            'totalSimpanan',
            'totalPinjaman',
            'totalPegawai',
            'simpananTerbaru',
            'pinjamanTerbaru'
        ));
    }
}
