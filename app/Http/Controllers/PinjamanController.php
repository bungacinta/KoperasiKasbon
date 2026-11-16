<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    // =========================
    // MENAMPILKAN RIWAYAT
    // =========================
    public function index()
    {
        $daftarPinjaman = Pinjaman::with(['anggota', 'petugas'])
            ->orderBy('id', 'desc')
            ->get();

        return view('pinjaman.index', compact('daftarPinjaman'));
    }

    // =========================
    // FORM INPUT PINJAMAN
    // =========================
    public function create()
    {
        $daftarAnggota = Anggota::where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        return view('pinjaman.create', compact('daftarAnggota'));
    }

    // =========================
    // MENYIMPAN PINJAMAN
    // =========================
    public function store(Request $request)
    {
        $dataBaru = $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jumlah' => 'required|integer|min:1000',
            'keperluan' => 'nullable|string|max:255',
        ], [
            'required' => ':attribute harus diisi.',
            'integer' => ':attribute harus berupa angka tanpa titik.',
            'min' => ':attribute minimal Rp :min.',
            'exists' => ':attribute tidak ditemukan.',
            'max' => ':attribute terlalu panjang.',
        ], [
            'anggota_id' => 'Anggota',
            'jumlah' => 'Jumlah pinjaman',
            'keperluan' => 'Keperluan',
        ]);

        $anggota = Anggota::findOrFail($dataBaru['anggota_id']);

        if ($anggota->status != 'aktif') {
            return back()
                ->withErrors([
                    'anggota_id' => $anggota->nama . ' berstatus nonaktif.'
                ])
                ->withInput();
        }

        $pinjaman = Pinjaman::create([
            'anggota_id' => $anggota->id,
            'user_id' => auth()->id(),
            'jumlah' => $dataBaru['jumlah'],
            'keperluan' => $dataBaru['keperluan'] ?? null,
            'tanggal' => now()->toDateString(),
        ]);

        return redirect()->route('dashboard')
            ->with('sukses', 'Pinjaman ' . $anggota->nama . ' berhasil dicatat.')
            ->with('nota', route('pinjaman.nota', $pinjaman));
    }

    // =========================
    // FORM EDIT PINJAMAN
    // =========================
    public function edit(Pinjaman $pinjaman)
    {
        $daftarAnggota = Anggota::orderBy('nama')->get();

        return view('pinjaman.edit', compact(
            'pinjaman',
            'daftarAnggota'
        ));
    }

    // =========================
    // UPDATE PINJAMAN
    // =========================
    public function update(Request $request, Pinjaman $pinjaman)
    {
        $data = $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jumlah' => 'required|integer|min:1000',
            'keperluan' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
        ], [
            'required' => ':attribute harus diisi.',
            'integer' => ':attribute harus berupa angka.',
            'min' => ':attribute minimal Rp :min.',
            'exists' => ':attribute tidak ditemukan.',
            'max' => ':attribute terlalu panjang.',
            'date' => ':attribute tidak valid.',
        ], [
            'anggota_id' => 'Anggota',
            'jumlah' => 'Jumlah pinjaman',
            'keperluan' => 'Keperluan',
            'tanggal' => 'Tanggal pinjaman',
        ]);

        // Memperbarui data tanpa mengubah petugas pencatat
        $pinjaman->anggota_id = $data['anggota_id'];
        $pinjaman->jumlah = $data['jumlah'];
        $pinjaman->keperluan = $data['keperluan'] ?? null;
        $pinjaman->tanggal = $data['tanggal'];

        $pinjaman->save();

        return redirect()->route('pinjaman.index')
            ->with('sukses', 'Data pinjaman berhasil diperbarui.');
    }

    // =========================
    // HAPUS PINJAMAN
    // =========================
    public function destroy(Pinjaman $pinjaman)
    {
        $pinjaman->delete();

        return redirect()->route('pinjaman.index')
            ->with('sukses', 'Data pinjaman berhasil dihapus.');
    }

    // =========================
    // CETAK NOTA
    // =========================
    public function nota(Pinjaman $pinjaman)
    {
        $pinjaman->load(['anggota', 'petugas']);

        return view('pinjaman.nota', compact('pinjaman'));
    }
}
