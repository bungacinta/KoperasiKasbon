
@extends('layouts.app')

@section('title', $anggota ? 'Edit Anggota' : 'Tambah Anggota')

@section('content')

<h1 class="h4 mb-3">
    {{ $anggota ? 'Edit Anggota' : 'Tambah Anggota' }}
</h1>

<form method="post"
      class="card p-4 cek-form"
      novalidate
      action="{{ $anggota ? route('anggota.update', ['anggotum' => $anggota->getRouteKey()]) : route('anggota.store') }}">

    @csrf

    @if ($anggota)
        @method('PUT')
    @endif

    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Nama lengkap</label>
            <input
                type="text"
                name="nama"
                class="form-control"
                value="{{ old('nama', $anggota ? $anggota->nama : '') }}"
                required
            >
        </div>

        <div class="col-md-3">
            <label class="form-label">Telepon</label>
            <input
                type="text"
                name="telepon"
                class="form-control"
                value="{{ old('telepon', $anggota ? $anggota->telepon : '') }}"
                required
            >
        </div>

        <div class="col-md-3">
            <label class="form-label">Tanggal bergabung</label>
            <input
                type="date"
                name="tanggal_gabung"
                class="form-control"
                value="{{ old('tanggal_gabung', $anggota ? $anggota->tanggal_gabung : date('Y-m-d')) }}"
                required
            >
        </div>

        <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea
                name="alamat"
                class="form-control"
                rows="2"
            >{{ old('alamat', $anggota ? $anggota->alamat : '') }}</textarea>
        </div>

    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-kas">
            Simpan
        </button>

        <a href="{{ route('anggota.index') }}" class="btn btn-link">
            Batal
        </a>
    </div>

</form>

@endsection
