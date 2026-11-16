<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    // ADMIN DAN MANAJER BISA MELIHAT DAFTAR ANGGOTA
    public function index()
    {
        $daftarAnggota = Anggota::withSum('simpanan as total_simpanan', 'jumlah')
            ->withSum('pinjaman as total_pinjaman', 'jumlah')
            ->orderBy('nomor_anggota')
            ->get();

        return view('anggota.index', compact('daftarAnggota'));
    }

    // MENAMPILKAN FORM TAMBAH ANGGOTA
    public function create()
    {
        $anggota = null;

        return view('anggota.form', compact('anggota'));
    }

    // MENYIMPAN ANGGOTA BARU
    public function store(Request $request)
    {
        $dataBaru = $request->validate([
            'nama' => 'required|max:100',
            'telepon' => 'required|max:20',
            'tanggal_gabung' => 'required|date',
            'alamat' => 'nullable',
        ], $this->pesanValidasi());

        // Nomor anggota dibuat otomatis
        $nomorUrut = Anggota::max('id') + 1;
        $nomorAnggota = 'AGT-' . str_pad($nomorUrut, 4, '0', STR_PAD_LEFT);

        Anggota::create([
            'nomor_anggota' => $nomorAnggota,
            'nama' => $dataBaru['nama'],
            'telepon' => $dataBaru['telepon'],
            'tanggal_gabung' => $dataBaru['tanggal_gabung'],
            'status' => 'aktif',
            'alamat' => $dataBaru['alamat'],
        ]);

        return redirect()->route('anggota.index')
            ->with('sukses', 'Anggota berhasil ditambahkan.');
    }

    // MENAMPILKAN FORM EDIT ANGGOTA
    public function edit(Anggota $anggotum)
    {
        $anggota = $anggotum;

        return view('anggota.form', compact('anggota'));
    }

    // MEMPERBARUI DATA ANGGOTA
    public function update(Request $request, Anggota $anggotum)
    {
        $dataBaru = $request->validate([
            'nama' => 'required|max:100',
            'telepon' => 'required|max:20',
            'tanggal_gabung' => 'required|date',
            'alamat' => 'nullable',
        ], $this->pesanValidasi());

        $anggotum->update([
            'nama' => $dataBaru['nama'],
            'telepon' => $dataBaru['telepon'],
            'tanggal_gabung' => $dataBaru['tanggal_gabung'],
            'alamat' => $dataBaru['alamat'],
        ]);

        return redirect()->route('anggota.index')
            ->with('sukses', 'Data anggota berhasil disimpan.');
    }

    // MENGAKTIFKAN ATAU MENONAKTIFKAN ANGGOTA
    public function ubahStatus(Anggota $anggota)
    {
        $statusBaru = $anggota->status == 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $anggota->update([
            'status' => $statusBaru
        ]);

        return back()->with(
            'sukses',
            $anggota->nama . ' sekarang ' . $statusBaru . '.'
        );
    }

    // MENGHAPUS ANGGOTA
    public function destroy(Anggota $anggotum)
    {
        // Anggota yang memiliki riwayat transaksi tidak boleh dihapus
        if (
            $anggotum->simpanan()->exists() ||
            $anggotum->pinjaman()->exists()
        ) {
            abort(
                403,
                'Anggota ini punya riwayat simpan pinjam. Nonaktifkan saja, jangan dihapus.'
            );
        }

        $anggotum->delete();

        return back()->with(
            'sukses',
            'Anggota berhasil dihapus.'
        );
    }

    // PESAN VALIDASI
    private function pesanValidasi()
    {
        return [
            'required' => ':attribute harus diisi.',
            'date' => ':attribute bukan tanggal yang benar.',
        ];
    }
}
