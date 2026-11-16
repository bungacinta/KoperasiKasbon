@extends('layouts.app')

@section('title', 'Data Simpanan')

@section('content')

@php
    $peran = strtolower(
        (string) \App\Models\User::peranDariEmail(auth()->user()->email)
    );
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Riwayat Simpanan</h1>

    @if ($peran === 'admin')
        <a href="{{ route('simpanan.create') }}" class="btn btn-kas">
            + Input Simpanan
        </a>
    @endif
</div>

@if (session('sukses'))
    <div class="alert alert-success">
        {{ session('sukses') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card p-3">
    <div class="table-responsive">

        <table class="table table-bordered table-hover align-middle">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Anggota</th>
                    <th>Jenis Simpanan</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Petugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($daftarSimpanan as $simpanan)

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $simpanan->anggota->nomor_anggota ?? '-' }}
                            -
                            {{ $simpanan->anggota->nama ?? '-' }}
                        </td>

                        <td>{{ ucfirst($simpanan->jenis) }}</td>

                        <td>
                            Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($simpanan->tanggal)->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $simpanan->petugas->name ?? '-' }}
                        </td>

                        <td>
                            <div class="d-flex gap-1">

                                {{-- NOTA: ADMIN DAN MANAJER --}}
                                <a href="{{ route('simpanan.nota', $simpanan->id) }}"
                                   class="btn btn-info btn-sm">
                                    Nota
                                </a>

                                {{-- EDIT DAN HAPUS: KHUSUS ADMIN --}}
                                @if ($peran === 'admin')

                                    <a href="{{ route('simpanan.edit', $simpanan->id) }}"
                                       class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('simpanan.destroy', $simpanan->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data simpanan ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>

                                    </form>

                                @endif

                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada data simpanan.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection