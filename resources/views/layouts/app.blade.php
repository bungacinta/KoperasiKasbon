<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'KASBON')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">

    <link href="{{ asset('css/kasbon.css') }}" rel="stylesheet">
</head>

<body>

@auth

    @php
        $peran = strtolower(
            (string) \App\Models\User::peranDariEmail(auth()->user()->email)
        );
    @endphp

    <nav class="navbar navbar-expand-md navbar-dark nav-pegawai">

        <div class="container">

            {{-- BRAND --}}
            <a class="navbar-brand brand fw-bold"
               href="{{ route('dashboard') }}">

                KASBON

                <span class="badge badge-role-pegawai fs-6 ms-1">
                    {{ ucfirst($peran ?: 'Pengguna') }}
                </span>

            </a>

            {{-- TOMBOL RESPONSIVE --}}
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuUtama"
                    aria-controls="menuUtama"
                    aria-expanded="false"
                    aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="menuUtama">

                <ul class="navbar-nav me-auto">

                    {{-- DASHBOARD --}}
                    <li class="nav-item">

                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">

                            <i class="bi bi-grid me-1"></i>
                            Dashboard

                        </a>

                    </li>

                    {{-- ANGGOTA --}}
                    <li class="nav-item">

                        <a class="nav-link {{ request()->routeIs('anggota.*') ? 'active' : '' }}"
                           href="{{ route('anggota.index') }}">

                            <i class="bi bi-people me-1"></i>
                            Anggota

                        </a>

                    </li>

                    {{-- PEGAWAI KHUSUS MANAJER --}}
                    @if ($peran === 'manajer')

                        <li class="nav-item">

                            <a class="nav-link {{ request()->routeIs('pegawai.*') ? 'active' : '' }}"
                               href="{{ route('pegawai.index') }}">

                                <i class="bi bi-person-badge me-1"></i>
                                Pegawai

                            </a>

                        </li>

                    @endif

                    {{-- SIMPANAN --}}
                    <li class="nav-item">

                        <a class="nav-link {{ request()->routeIs('simpanan.*') ? 'active' : '' }}"
                           href="{{ route('simpanan.index') }}">

                            <i class="bi bi-wallet2 me-1"></i>
                            Simpanan

                        </a>

                    </li>

                    {{-- PINJAMAN --}}
                    <li class="nav-item">

                        <a class="nav-link {{ request()->routeIs('pinjaman.*') ? 'active' : '' }}"
                           href="{{ route('pinjaman.index') }}">

                            <i class="bi bi-cash-stack me-1"></i>
                            Pinjaman

                        </a>

                    </li>

                </ul>

                {{-- NAMA PENGGUNA --}}
                <span class="navbar-text me-3 small text-white">

                    <i class="bi bi-person-circle me-1"></i>

                    {{ auth()->user()->name }}

                </span>

                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            class="btn btn-sm btn-light fw-semibold">

                        <i class="bi bi-box-arrow-right me-1"></i>
                        Keluar

                    </button>

                </form>

            </div>

        </div>

    </nav>

@endauth


<main class="container py-4 muncul">

    {{-- NOTIFIKASI SUKSES --}}
    @if (session('sukses'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('sukses') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>

    @endif

    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>

        </div>

    @endif

    {{-- NOTIFIKASI ERROR --}}
    @if ($errors->any() && auth()->check())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $pesanError)

                    <li>{{ $pesanError }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- ISI HALAMAN --}}
    @yield('content')

</main>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('js/kasbon.js') }}"></script>

{{-- Memanggil JavaScript tambahan dari setiap halaman --}}
@stack('scripts')

</body>
</html>