@extends('layouts.app')

@section('title', 'Edit Simpanan')

@section('content')

<h1 class="h4 mb-3">Edit Simpanan</h1>

<form method="POST"
      action="{{ route('simpanan.update', $simpanan->id) }}"
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
                        {{ old('anggota_id', $simpanan->anggota_id) == $anggota->id ? 'selected' : '' }}>

                        {{ $anggota->nomor_anggota }} - {{ $anggota->nama }}

                    </option>
                @endforeach
            </select>

            @error('anggota_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-3">
            <label class="form-label">Jenis Simpanan</label>

            <select name="jenis" class="form-select" required>

                @foreach ($jenisSimpanan as $jenis)
                    <option value="{{ $jenis }}"
                        {{ old('jenis', $simpanan->jenis) == $jenis ? 'selected' : '' }}>

                        {{ ucfirst($jenis) }}

                    </option>
                @endforeach

            </select>

            @error('jenis')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-3">
            <label class="form-label">Jumlah (Rp)</label>

            <input type="number"
                   name="jumlah"
                   class="form-control"
                   min="1000"
                   value="{{ old('jumlah', $simpanan->jumlah) }}"
                   required>

            @error('jumlah')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Tanggal Simpanan</label>

            <input type="date"
                   name="tanggal"
                   class="form-control"
                   value="{{ old('tanggal', $simpanan->tanggal) }}"
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

        <a href="{{ route('simpanan.index') }}" class="btn btn-link">
            Batal
        </a>
    </div>

</form>

@endsection
