@extends('layouts.app')

@section('title', 'Input Pinjaman')

@section('content')
<h1 class="h4 mb-3">Input Pinjaman</h1>

<form method="post" action="{{ route('pinjaman.store') }}" class="card p-4 cek-form" novalidate>
    @csrf

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Anggota</label>
            <select name="anggota_id" class="form-select" required>
                <option value="">Pilih anggota</option>
                @foreach ($daftarAnggota as $anggota)
                    <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                        {{ $anggota->nomor_anggota }} - {{ $anggota->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Jumlah pinjaman (Rp)</label>
            <input type="number" name="jumlah" class="form-control" min="1000"
                   value="{{ old('jumlah') }}" required>
        </div>

        <div class="col-12">
            <label class="form-label">Keperluan (boleh kosong)</label>
            <input type="text" name="keperluan" class="form-control" value="{{ old('keperluan') }}">
        </div>
    </div>

    <div class="mt-4">
        <button class="btn btn-kas">Simpan</button>
        <a href="{{ route('dashboard') }}" class="btn btn-link">Batal</a>
    </div>
</form>
@endsection