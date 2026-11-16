$(document).ready(function () {

    // =====================================
    // PENGATURAN AWAL
    // =====================================

    const form = $('#formPegawai');
    const modalElement = document.getElementById('modalPegawai');
    const modalPegawai = new bootstrap.Modal(modalElement);

    const modalDetailElement = document.getElementById('modalDetail');

    const urlData = '/pegawai/data';
    const urlPegawai = '/pegawai';

    let semuaPegawai = [];

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });

    // MENGAMANKAN TEKS YANG DITAMPILKAN
    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    // =====================================
    // NOTIFIKASI
    // =====================================

    function tampilPesan(pesan, tipe = 'success') {
        $('#pesan').html(`
            <div class="alert alert-${tipe} alert-dismissible fade show">
                ${escapeHtml(pesan)}
                <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
            </div>
        `);

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // =====================================
    // MEMUAT DATA PEGAWAI
    // =====================================

    function loadPegawai() {

        $('#tabelPegawai').html(`
            <tr>
                <td colspan="7" class="text-center">
                    Memuat data...
                </td>
            </tr>
        `);

        $.ajax({
            url: urlData,
            method: 'GET',

            success: function (response) {

                if (!response.sukses) {
                    tampilPesan(response.pesan, 'danger');
                    return;
                }

                semuaPegawai = response.data || [];

                tampilTabel(semuaPegawai);
            },

            error: function (xhr) {

                console.error(xhr.responseText);

                $('#tabelPegawai').html(`
                    <tr>
                        <td colspan="7" class="text-center text-danger">
                            Gagal mengambil data pegawai.
                        </td>
                    </tr>
                `);
            }
        });
    }

    // =====================================
    // MENAMPILKAN TABEL
    // =====================================

    function tampilTabel(data) {

        let html = '';

        if (data.length === 0) {

            $('#tabelPegawai').html(`
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        Belum ada data pegawai.
                    </td>
                </tr>
            `);

            return;
        }

        data.forEach(function (p, index) {

            const warna = p.status === 'Aktif'
                ? 'success'
                : 'secondary';

            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${escapeHtml(p.nip)}</td>
                    <td>${escapeHtml(p.nama)}</td>
                    <td>${escapeHtml(p.jabatan)}</td>
                    <td>${escapeHtml(p.departemen)}</td>

                    <td>
                        <span class="badge bg-${warna}">
                            ${escapeHtml(p.status)}
                        </span>
                    </td>

                    <td class="text-nowrap">

                        <button type="button"
                            class="btn btn-sm btn-info tombol-detail"
                            data-id="${p.id}" title="Detail">
                            <i class="bi bi-eye"></i>
                        </button>

                        <button type="button"
                            class="btn btn-sm btn-warning tombol-edit"
                            data-id="${p.id}" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <button type="button"
                            class="btn btn-sm btn-danger tombol-hapus"
                            data-id="${p.id}" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>

                    </td>
                </tr>
            `;
        });

        $('#tabelPegawai').html(html);
    }

    // =====================================
    // PENCARIAN PEGAWAI
    // =====================================

    $('#cariPegawai').on('input', function () {

        const kata = $(this).val().toLowerCase();

        const hasil = semuaPegawai.filter(function (p) {

            return [
                p.nip,
                p.nama,
                p.jabatan,
                p.departemen,
                p.status
            ].some(function (nilai) {
                return String(nilai ?? '').toLowerCase().includes(kata);
            });

        });

        tampilTabel(hasil);
    });

    // =====================================
    // VALIDASI FORM (JAVASCRIPT)
    // =====================================

    const aturan = {
        nip: function (v) {
            if (v === '') return 'NIP wajib diisi.';
            if (!/^[0-9A-Za-z.\-]{4,30}$/.test(v)) return 'NIP 4 sampai 30 karakter (huruf, angka, titik, strip).';
            return '';
        },
        nama: function (v) {
            if (v === '') return 'Nama wajib diisi.';
            if (v.length < 3) return 'Nama minimal 3 huruf.';
            return '';
        },
        jenis_kelamin: function (v) {
            return v === '' ? 'Pilih jenis kelamin.' : '';
        },
        email: function (v) {
            if (v === '') return 'Email wajib diisi.';
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) return 'Format email tidak valid, contoh: nama@domain.com.';
            return '';
        },
        telepon: function (v) {
            if (v === '') return 'No. telepon wajib diisi.';
            if (!/^[0-9+]{9,15}$/.test(v)) return 'Telepon harus 9 sampai 15 angka.';
            return '';
        },
        jabatan: function (v) {
            return v === '' ? 'Jabatan wajib diisi.' : '';
        },
        departemen: function (v) {
            return v === '' ? 'Departemen wajib diisi.' : '';
        },
        tanggal_masuk: function (v) {
            return v === '' ? 'Tanggal masuk wajib diisi.' : '';
        },
        status: function (v) {
            return v === '' ? 'Pilih status.' : '';
        },
        alamat: function (v) {
            if (v === '') return 'Alamat wajib diisi.';
            if (v.length < 5) return 'Alamat minimal 5 karakter.';
            return '';
        }
    };

    // menampilkan atau menghapus pesan error di bawah satu kolom
    function setError(kolom, pesan) {
        kolom.next('.invalid-feedback').remove();
        kolom.removeClass('is-invalid is-valid');

        if (pesan) {
            kolom.addClass('is-invalid');
            kolom.after(`<div class="invalid-feedback">${escapeHtml(pesan)}</div>`);
            return false;
        }

        kolom.addClass('is-valid');
        return true;
    }

    // validasi satu kolom berdasarkan atribut name
    function cekKolom(kolom) {
        const nama = kolom.attr('name');
        const cek = aturan[nama];

        if (!cek) return true;

        return setError(kolom, cek($.trim(kolom.val())));
    }

    // validasi semua kolom, mengembalikan true jika semuanya benar
    function cekSemua() {
        let benar = true;

        form.find('input[name], select[name], textarea[name]').each(function () {
            if (!cekKolom($(this))) benar = false;
        });

        if (!benar) {
            form.find('.is-invalid').first().trigger('focus');
        }

        return benar;
    }

    // membersihkan tanda valid/invalid
    function bersihkanValidasi() {
        form.find('.invalid-feedback').remove();
        form.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $('#errorValidasi').html('');
    }

    // cek ulang ketika pengguna mengetik atau memilih
    form.on('input change', 'input[name], select[name], textarea[name]', function () {
        cekKolom($(this));
    });

    // =====================================
    // TAMBAH PEGAWAI
    // =====================================

    window.formTambah = function () {

        form[0].reset();

        $('#pegawai_id').val('');
        $('#judulModal').text('Tambah Pegawai');
        $('#tombolSimpan').html(
            '<i class="bi bi-save me-1"></i> Simpan Data'
        );

        bersihkanValidasi();

        modalPegawai.show();
    };

    // =====================================
    // SIMPAN DAN UPDATE PEGAWAI
    // =====================================

    form.on('submit', function (e) {

        e.preventDefault();

        // validasi JavaScript dijalankan sebelum data dikirim ke server
        if (!cekSemua()) {
            return;
        }

        const id = $('#pegawai_id').val();
        const modeEdit = id !== '';

        const url = modeEdit
            ? `${urlPegawai}/${encodeURIComponent(id)}`
            : urlPegawai;

        const data = form.serialize();

        const dataKirim = modeEdit
            ? data + '&_method=PUT'
            : data;

        const tombol = $('#tombolSimpan');

        tombol.prop('disabled', true)
              .text('Menyimpan...');

        $('#errorValidasi').html('');

        $.ajax({

            url: url,
            method: 'POST',
            data: dataKirim,

            success: function (response) {

                if (response.sukses) {

                    modalPegawai.hide();

                    tampilPesan(response.pesan, 'success');

                    form[0].reset();

                    $('#pegawai_id').val('');

                    loadPegawai();

                } else {

                    tampilPesan(
                        response.pesan || 'Gagal menyimpan data.',
                        'danger'
                    );
                }
            },

            error: function (xhr) {

                console.error(xhr.responseText);

                if (xhr.status === 422) {

                    const errors = xhr.responseJSON.errors || {};

                    // tampilkan error server tepat di bawah kolomnya
                    $.each(errors, function (kolom, daftar) {
                        const input = form.find('[name="' + kolom + '"]');

                        if (input.length) {
                            setError(input, daftar[0]);
                        }
                    });

                    form.find('.is-invalid').first().trigger('focus');

                } else if (xhr.status === 419) {

                    $('#errorValidasi').text(
                        'Sesi berakhir. Silakan refresh halaman.'
                    );

                } else {

                    $('#errorValidasi').text(
                        xhr.responseJSON?.pesan ||
                        xhr.responseJSON?.message ||
                        'Terjadi kesalahan ketika menyimpan data.'
                    );
                }
            },

            complete: function () {

                tombol.prop('disabled', false);

                tombol.html(
                    modeEdit
                        ? '<i class="bi bi-save me-1"></i> Update Data'
                        : '<i class="bi bi-save me-1"></i> Simpan Data'
                );
            }

        });

    });

    // =====================================
    // DETAIL PEGAWAI
    // =====================================

    $(document).on('click', '.tombol-detail', function () {

        const id = $(this).data('id');

        $.ajax({

            url: `${urlPegawai}/${encodeURIComponent(id)}`,
            method: 'GET',

            success: function (response) {

                if (!response.sukses) return;

                const p = response.data;

                const kolom = [
                    ['NIP', p.nip],
                    ['Nama', p.nama],
                    ['Jenis Kelamin', p.jenis_kelamin],
                    ['Email', p.email],
                    ['Telepon', p.telepon],
                    ['Jabatan', p.jabatan],
                    ['Departemen', p.departemen],
                    ['Tanggal Masuk', p.tanggal_masuk],
                    ['Alamat', p.alamat],
                    ['Status', p.status]
                ];

                let html = '<table class="table table-bordered">';

                kolom.forEach(function (item) {

                    html += `
                        <tr>
                            <th style="width:35%">
                                ${escapeHtml(item[0])}
                            </th>
                            <td>${escapeHtml(item[1])}</td>
                        </tr>
                    `;
                });

                html += '</table>';

                $('#isiDetail').html(html);

                bootstrap.Modal.getOrCreateInstance(
                    modalDetailElement
                ).show();
            },

            error: function (xhr) {
                tampilPesan(
                    xhr.responseJSON?.pesan ||
                    'Gagal mengambil detail pegawai.',
                    'danger'
                );
            }

        });
    });

    // =====================================
    // EDIT PEGAWAI
    // =====================================

    $(document).on('click', '.tombol-edit', function () {

        const id = $(this).data('id');

        $.get(`${urlPegawai}/${encodeURIComponent(id)}`)

            .done(function (response) {

                if (!response.sukses) return;

                const p = response.data;

                form[0].reset();

                $('#pegawai_id').val(p.id);
                $('#nip').val(p.nip);
                $('#nama').val(p.nama);
                $('#jenis_kelamin').val(p.jenis_kelamin);
                $('#email').val(p.email);
                $('#telepon').val(p.telepon);
                $('#jabatan').val(p.jabatan);
                $('#departemen').val(p.departemen);
                $('#tanggal_masuk').val(p.tanggal_masuk);
                $('#alamat').val(p.alamat);
                $('#status').val(p.status);

                $('#judulModal').text('Edit Pegawai');

                $('#tombolSimpan').html(
                    '<i class="bi bi-save me-1"></i> Update Data'
                );

                bersihkanValidasi();

                modalPegawai.show();

            })

            .fail(function (xhr) {

                tampilPesan(
                    xhr.responseJSON?.pesan ||
                    'Gagal mengambil data pegawai.',
                    'danger'
                );
            });
    });

    // =====================================
    // HAPUS PEGAWAI
    // =====================================

    $(document).on('click', '.tombol-hapus', function () {

        const id = $(this).data('id');

        if (!confirm('Apakah kamu yakin ingin menghapus pegawai ini?')) {
            return;
        }

        $.ajax({

            url: `${urlPegawai}/${encodeURIComponent(id)}`,
            method: 'POST',

            data: {
                _method: 'DELETE'
            },

            success: function (response) {

                if (response.sukses) {

                    tampilPesan(response.pesan, 'success');

                    loadPegawai();

                } else {

                    tampilPesan(response.pesan, 'danger');
                }
            },

            error: function (xhr) {

                console.error(xhr.responseText);

                tampilPesan(
                    xhr.responseJSON?.pesan ||
                    xhr.responseJSON?.message ||
                    'Gagal menghapus pegawai.',
                    'danger'
                );
            }

        });
    });

    // =====================================
    // RESET FORM
    // =====================================

    $('#modalPegawai').on('hidden.bs.modal', function () {

        form[0].reset();

        $('#pegawai_id').val('');
        bersihkanValidasi();

    });

    // =====================================
    // LOAD DATA PERTAMA KALI
    // =====================================

    loadPegawai();

});