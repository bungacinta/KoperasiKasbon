<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Simpanan;
use Illuminate\Http\Request;

class SimpananController extends Controller
{
    // MENAMPILKAN RIWAYAT SIMPANAN
    public function index()
    {
        $daftarSimpanan = Simpanan::with(['anggota', 'petugas'])
            ->orderBy('id', 'desc')
            ->get();

        return view('simpanan.index', compact('daftarSimpanan'));
    }

    // FORM INPUT SIMPANAN
    public function create()
    {
        $daftarAnggota = Anggota::where('status', 'aktif')
            ->withSum('simpanan as total_simpanan', 'jumlah')
            ->orderBy('nama')
            ->get();

        $jenisSimpanan = Simpanan::JENIS;

        return view('simpanan.create', compact(
            'daftarAnggota',
            'jenisSimpanan'
        ));
    }

    // MENYIMPAN SIMPANAN
    public function store(Request $request)
    {
        $dataBaru = $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jenis' => 'required|in:' . implode(',', Simpanan::JENIS),
            'jumlah' => 'required|integer|min:1000',
        ]);

        $anggota = Anggota::findOrFail($dataBaru['anggota_id']);

        if ($anggota->status != 'aktif') {
            return back()
                ->withErrors([
                    'anggota_id' => $anggota->nama . ' berstatus nonaktif.'
                ])
                ->withInput();
        }

        $simpanan = Simpanan::create([
            'anggota_id' => $anggota->id,
            'user_id' => auth()->id(),
            'jenis' => $dataBaru['jenis'],
            'jumlah' => $dataBaru['jumlah'],
            'tanggal' => now()->toDateString(),
        ]);

        return redirect()->route('dashboard')
            ->with('sukses', 'Simpanan ' . $anggota->nama . ' berhasil dicatat.')
            ->with('nota', route('simpanan.nota', $simpanan));
    }

    // FORM EDIT SIMPANAN
    public function edit(Simpanan $simpanan)
    {
        $daftarAnggota = Anggota::orderBy('nama')->get();

        $jenisSimpanan = Simpanan::JENIS;

        return view('simpanan.edit', compact(
            'simpanan',
            'daftarAnggota',
            'jenisSimpanan'
        ));
    }

    // UPDATE SIMPANAN
    public function update(Request $request, Simpanan $simpanan)
    {
        $data = $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jenis' => 'required|in:' . implode(',', Simpanan::JENIS),
            'jumlah' => 'required|integer|min:1000',
            'tanggal' => 'required|date',
        ]);

        $simpanan->update([
            'anggota_id' => $data['anggota_id'],
            'jenis' => $data['jenis'],
            'jumlah' => $data['jumlah'],
            'tanggal' => $data['tanggal'],
        ]);

        return redirect()->route('simpanan.index')
            ->with('sukses', 'Data simpanan berhasil diperbarui.');
    }

    // HAPUS SIMPANAN
    public function destroy(Simpanan $simpanan)
    {
        $simpanan->delete();

        return redirect()->route('simpanan.index')
            ->with('sukses', 'Data simpanan berhasil dihapus.');
    }

    // CETAK NOTA
    public function nota(Simpanan $simpanan)
    {
        $simpanan->load(['anggota', 'petugas']);

        $totalSimpanan = Simpanan::where(
            'anggota_id',
            $simpanan->anggota_id
        )
            ->where('id', '<=', $simpanan->id)
            ->sum('jumlah');

        return view('simpanan.nota', compact(
            'simpanan',
            'totalSimpanan'
        ));
    }
}
