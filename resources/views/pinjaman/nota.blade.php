<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nota {{ $pinjaman->nomorNota() }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/kasbon.css') }}" rel="stylesheet">
</head>
<body class="halaman-nota">

<div class="nota">
    <div class="text-center">
        <div class="fw-bold fs-5">KOPERASI KASBON</div>
        <div class="small">NOTA PINJAMAN</div>
    </div>
    <hr>

    <div class="baris"><span>No. nota</span><span>{{ $pinjaman->nomorNota() }}</span></div>
    <div class="baris"><span>Tanggal pinjam</span><span>{{ date('d-m-Y', strtotime($pinjaman->tanggal)) }}</span></div>
    <div class="baris"><span>Nama</span><span>{{ $pinjaman->anggota->nama }}</span></div>
    <div class="baris"><span>No. anggota</span><span>{{ $pinjaman->anggota->nomor_anggota }}</span></div>
    @if ($pinjaman->keperluan)
        <div class="baris"><span>Keperluan</span><span>{{ $pinjaman->keperluan }}</span></div>
    @endif
    <hr>

    <div class="baris fw-bold"><span>Total pinjaman</span><span>Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</span></div>
    <hr>

    <div class="baris small"><span>Petugas</span><span>{{ $pinjaman->petugas->name ?? '-' }}</span></div>
    <div class="text-center small mt-3">Terima kasih</div>
</div>

<div class="text-center tanpa-cetak mb-4">
    <button onclick="window.print()" class="btn btn-success">Cetak</button>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Kembali ke dashboard</a>
</div>

</body>
</html>