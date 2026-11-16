@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="banner-koperasi mb-4">
    <img src="{{ asset('img/koperasi.jpg') }}" alt="Gedung Koperasi KASBON">
</div>

<div class="d-flex justify-content-between flex-wrap gap-2 mb-3">

    <h1 class="h4 mb-0">
        Dashboard {{ auth()->user()->namaPeran() }}
    </h1>

    {{-- Tombol hanya muncul untuk Admin --}}
    @if (strtolower((string) \App\Models\User::peranDariEmail(auth()->user()->email)) === 'admin')
        <div class="d-flex gap-2">

            <a href="{{ route('simpanan.create') }}" class="btn btn-kas">
                <i class="bi bi-piggy-bank me-1"></i>
                Input simpanan
            </a>

            <a href="{{ route('pinjaman.create') }}" class="btn btn-warning">
                <i class="bi bi-cash-coin me-1"></i>
                Input pinjaman
            </a>

        </div>
    @endif

</div>

<div class="row g-3 mb-4">

    {{-- Kartu Anggota Aktif --}}
    <div class="col-md-4">
        <div class="card stat p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="text-muted small">Anggota aktif</div>
                    <div class="angka" data-target="{{ $jumlahAnggotaAktif }}">0</div>
                </div>

                <i class="bi bi-people fs-1 text-secondary"></i>
            </div>
        </div>
    </div>

    {{-- Kartu Total Simpanan --}}
    <div class="col-md-4">
        <div class="card stat p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="text-muted small">Total simpanan</div>
                    <div class="fs-4 fw-bold">
                        Rp {{ number_format($totalSimpanan, 0, ',', '.') }}
                    </div>
                </div>

                <i class="bi bi-piggy-bank fs-1 text-secondary"></i>
            </div>
        </div>
    </div>

    {{-- Kartu Total Pinjaman --}}
    <div class="col-md-4">
        <div class="card stat p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="text-muted small">Total pinjaman</div>
                    <div class="fs-4 fw-bold">
                        Rp {{ number_format($totalPinjaman, 0, ',', '.') }}
                    </div>
                </div>

                <i class="bi bi-cash-coin fs-1 text-secondary"></i>
            </div>
        </div>
    </div>

    {{-- Kartu Total Pegawai khusus Manajer --}}
    @if (strtolower((string) \App\Models\User::peranDariEmail(auth()->user()->email)) === 'manajer')
        <div class="col-md-4">
            <div class="card stat p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">Total Pegawai</div>

                        <div class="angka" data-target="{{ $totalPegawai }}">
                            0
                        </div>

                        <a href="{{ route('pegawai.index') }}"
                           class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-eye me-1"></i>
                            Lihat Data Pegawai
                        </a>
                    </div>

                    <i class="bi bi-person-badge fs-1 text-secondary"></i>
                </div>
            </div>
        </div>
    @endif

</div>

<div class="row g-3">

    {{-- Tabel Simpanan Terbaru --}}
    <div class="col-lg-6">
        <div class="card p-3 table-responsive h-100">

            <h2 class="h6">Simpanan terbaru</h2>

            <table class="table align-middle mb-0">

                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Anggota</th>
                        <th class="text-end">Jumlah</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($simpananTerbaru as $simpanan)
                        <tr>
                            <td>
                                {{ date('d-m-Y', strtotime($simpanan->tanggal)) }}
                            </td>

                            <td>
                                {{ $simpanan->anggota->nama ?? '-' }}
                            </td>

                            <td class="text-end">
                                Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}
                            </td>

                            <td class="text-end">
                                <a href="{{ route('simpanan.nota', $simpanan) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Belum ada simpanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

    {{-- Tabel Pinjaman Terbaru --}}
    <div class="col-lg-6">
        <div class="card p-3 table-responsive h-100">

            <h2 class="h6">Pinjaman terbaru</h2>

            <table class="table align-middle mb-0">

                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Anggota</th>
                        <th class="text-end">Jumlah</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pinjamanTerbaru as $pinjaman)
                        <tr>
                            <td>
                                {{ date('d-m-Y', strtotime($pinjaman->tanggal)) }}
                            </td>

                            <td>
                                {{ $pinjaman->anggota->nama ?? '-' }}
                            </td>

                            <td class="text-end">
                                Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}
                            </td>

                            <td class="text-end">
                                <a href="{{ route('pinjaman.nota', $pinjaman) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Belum ada pinjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
