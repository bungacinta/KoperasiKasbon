@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
@php
    $adalahManajer = auth()->user()->adalahManajer();
@endphp

<div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
    <h1 class="h4 mb-0">Daftar Anggota</h1>

    <div class="d-flex gap-2">
        <input type="text" id="cari" class="form-control" placeholder="Cari anggota...">

        @if ($adalahManajer)
            <a href="{{ route('anggota.create') }}" class="btn btn-kas text-nowrap">Tambah</a>
        @endif
    </div>
</div>

<div class="card p-3 table-responsive">
    <table id="tabel" class="table align-middle mb-0">
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th class="text-end">Total simpanan</th>
                <th class="text-end">Total pinjaman</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($daftarAnggota as $anggota)
                <tr class="{{ $anggota->status == 'aktif' ? '' : 'text-muted' }}">
                    <td>{{ $anggota->nomor_anggota }}</td>
                    <td>{{ $anggota->nama }}</td>
                    <td>{{ $anggota->telepon }}</td>
                    <td class="text-end">Rp {{ number_format($anggota->total_simpanan ?? 0, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($anggota->total_pinjaman ?? 0, 0, ',', '.') }}</td>
                    <td>
                        @if ($anggota->status == 'aktif')
                            <span class="badge text-bg-success">aktif</span>
                        @else
                            <span class="badge text-bg-secondary">nonaktif</span>
                        @endif
                    </td>
                    <td class="text-end text-nowrap">
                        @if ($adalahManajer)
                            <form method="post" action="{{ route('anggota.status', $anggota) }}" class="d-inline"
                                  onsubmit="return confirm('{{ $anggota->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} {{ $anggota->nama }}?')">
                                @csrf
                                @method('PATCH')
                                @if ($anggota->status == 'aktif')
                                    <button class="btn btn-sm btn-outline-warning">Nonaktifkan</button>
                                @else
                                    <button class="btn btn-sm btn-outline-primary">Aktifkan</button>
                                @endif
                            </form>

                            <a href="{{ route('anggota.edit', $anggota) }}" class="btn btn-sm btn-outline-success">Edit</a>

                            <form method="post" action="{{ route('anggota.destroy', $anggota) }}"
                                  class="d-inline form-hapus" data-nama="{{ $anggota->nama }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection