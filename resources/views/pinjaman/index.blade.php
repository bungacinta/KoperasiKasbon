
@extends('layouts.app')

@section('title', 'Riwayat Pinjaman')

@section('content')

@php
    $peran = strtolower(
        (string) \App\Models\User::peranDariEmail(auth()->user()->email)
    );
@endphp

{{-- JUDUL DAN TOMBOL INPUT --}}
<div class="d-flex justify-content-between flex-wrap gap-2 mb-3">

    <h1 class="h4 mb-0">Riwayat Pinjaman</h1>

    {{-- INPUT KHUSUS ADMIN --}}
    @if ($peran === 'admin')

        <a href="{{ route('pinjaman.create') }}" class="btn btn-warning">

            <i class="bi bi-cash-coin me-1"></i>
            Input pinjaman

        </a>

    @endif

</div>

{{-- NOTIFIKASI BERHASIL --}}
@if (session('sukses'))

    <div class="alert alert-success alert-dismissible fade show">

        <i class="bi bi-check-circle me-1"></i>
        {{ session('sukses') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif

{{-- NOTIFIKASI ERROR --}}
@if ($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

{{-- TABEL RIWAYAT PINJAMAN --}}
<div class="card p-3 table-responsive">

    <table class="table align-middle mb-0">

        <thead>
            <tr>
                <th>No. nota</th>
                <th>Tanggal</th>
                <th>Anggota</th>
                <th>Keperluan</th>
                <th class="text-end">Jumlah</th>
                <th>Petugas</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($daftarPinjaman as $pinjaman)

                <tr>

                    <td>
                        {{ $pinjaman->nomorNota() }}
                    </td>

                    <td>
                        {{ date('d-m-Y', strtotime($pinjaman->tanggal)) }}
                    </td>

                    <td>
                        {{ $pinjaman->anggota->nama ?? '-' }}
                    </td>

                    <td>
                        {{ $pinjaman->keperluan ?? '-' }}
                    </td>

                    <td class="text-end">
                        Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $pinjaman->petugas->name ?? '-' }}
                    </td>

                    {{-- TOMBOL AKSI --}}
                    <td class="text-center text-nowrap">

                        {{-- KHUSUS ADMIN --}}
                        @if ($peran === 'admin')

                            {{-- EDIT --}}
                            <a href="{{ route('pinjaman.edit', $pinjaman) }}"
                               class="btn btn-sm btn-warning mb-1">

                                <i class="bi bi-pencil-square"></i>
                                Edit

                            </a>

                            {{-- HAPUS --}}
                            <form action="{{ route('pinjaman.destroy', $pinjaman) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Apakah kamu yakin ingin menghapus pinjaman {{ $pinjaman->nomorNota() }}?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-sm btn-danger mb-1">

                                    <i class="bi bi-trash"></i>
                                    Hapus

                                </button>

                            </form>

                        @endif

                        {{-- CETAK UNTUK ADMIN DAN MANAJER --}}
                        <a href="{{ route('pinjaman.nota', $pinjaman) }}"
                           class="btn btn-sm btn-outline-success mb-1">

                            <i class="bi bi-printer me-1"></i>
                            Cetak

                        </a>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        Belum ada pinjaman.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection
