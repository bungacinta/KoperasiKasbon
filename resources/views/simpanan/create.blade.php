@extends('layouts.app')

@section('title', 'Input Simpanan')

@section('content')
<h1 class="h4 mb-3">Input Simpanan</h1>

<form method="post" action="{{ route('simpanan.store') }}" class="card p-4 cek-form" novalidate>
    @csrf

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Anggota</label>
            <select name="anggota_id" class="form-select" required>
                <option value="">Pilih anggota</option>
                @foreach ($daftarAnggota as $anggota)
                    <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                        {{ $anggota->nomor_anggota }} - {{ $anggota->nama }}
                        (simpanan Rp {{ number_format($anggota->total_simpanan ?? 0, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Jenis simpanan</label>
            <select name="jenis" class="form-select" required>
                @foreach ($jenisSimpanan as $jenis)
                    <option value="{{ $jenis }}" {{ old('jenis') == $jenis ? 'selected' : '' }}>
                        {{ ucfirst($jenis) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" class="form-control" min="1000"
                   value="{{ old('jumlah') }}" required>
        </div>
    </div>

    <div class="mt-4">
        <button class="btn btn-kas">Simpan</button>
        <a href="{{ route('dashboard') }}" class="btn btn-link">Batal</a>
    </div>
</form>
@endsection