<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nota {{ $simpanan->nomorNota() }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f6f7f3; font-family: 'Courier New', monospace; }
        .nota { max-width: 380px; margin: 24px auto; background: #fff; padding: 24px; border: 1px dashed #888; }
        .baris { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 4px; }
        @media print {
            body { background: #fff; }
            .nota { border: 0; margin: 0; max-width: 100%; }
            .tanpa-cetak { display: none !important; }
        }
    </style>
</head>
<body>

<div class="nota">
    <div class="text-center">
        <div class="fw-bold fs-5">KOPERASI KASBON</div>
        <div class="small">NOTA SIMPANAN</div>
    </div>
    <hr>

    <div class="baris"><span>No. nota</span><span>{{ $simpanan->nomorNota() }}</span></div>
    <div class="baris"><span>Tanggal</span><span>{{ date('d-m-Y', strtotime($simpanan->tanggal)) }}</span></div>
    <div class="baris"><span>Nama</span><span>{{ $simpanan->anggota->nama }}</span></div>
    <div class="baris"><span>No. anggota</span><span>{{ $simpanan->anggota->nomor_anggota }}</span></div>
    <div class="baris"><span>Jenis transaksi</span><span>Simpanan {{ ucfirst($simpanan->jenis) }}</span></div>
    <hr>

    <div class="baris fw-bold"><span>Setoran</span><span>Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</span></div>
    <div class="baris"><span>Total simpanan</span><span>Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</span></div>
    <hr>

    <div class="baris small"><span>Petugas</span><span>{{ $simpanan->petugas->name ?? '-' }}</span></div>
    <div class="text-center small mt-3">Terima kasih</div>
</div>

<div class="text-center tanpa-cetak mb-4">
    <button onclick="window.print()" class="btn btn-success">Cetak</button>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Kembali ke dashboard</a>
</div>

</body>
</html>