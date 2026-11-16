@extends('layouts.app')

@section('title', 'Edit Pinjaman')

@section('content')

<h1 class="h4 mb-3">Edit Pinjaman</h1>

<form method="POST"
      action="{{ route('pinjaman.update', $pinjaman->id) }}"
      class="card p-4 cek-form"
      novalidate>

    @csrf
    @method('PUT')

    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Anggota</label>

            <select name="anggota_id" class="form-select" required>
                <option value="">Pilih anggota</option>

                @foreach ($daftarAnggota as $anggota)
                    <option value="{{ $anggota->id }}"
                        {{ old('anggota_id', $pinjaman->anggota_id) == $anggota->id ? 'selected' : '' }}>

                        {{ $anggota->nomor_anggota }} - {{ $anggota->nama }}

                    </option>
                @endforeach
            </select>

            @error('anggota_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Jumlah Pinjaman (Rp)</label>

            <input type="number"
                   name="jumlah"
                   class="form-control"
                   min="1000"
                   value="{{ old('jumlah', $pinjaman->jumlah) }}"
                   required>

            @error('jumlah')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label">Keperluan (boleh kosong)</label>

            <input type="text"
                   name="keperluan"
                   class="form-control"
                   value="{{ old('keperluan', $pinjaman->keperluan) }}">

            @error('keperluan')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Tanggal Pinjaman</label>

            <input type="date"
                   name="tanggal"
                   class="form-control"
                   value="{{ old('tanggal', $pinjaman->tanggal) }}"
                   required>

            @error('tanggal')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-kas">
            Update
        </button>

        <a href="{{ route('pinjaman.index') }}" class="btn btn-link">
            Batal
        </a>
    </div>

</form>

@endsection
