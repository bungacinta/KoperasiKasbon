
$(document).ready(function () {

    // token csrf supaya request ajax tidak ditolak oleh laravel
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // animasi angka di dashboard, menghitung naik dari 0
    $('.angka').each(function () {
        var elemenAngka = $(this);
        var angkaTujuan = parseInt(elemenAngka.data('target'));
        var angkaSekarang = 0;
        var tambahan = Math.ceil(angkaTujuan / 25);

        if (tambahan < 1) {
            tambahan = 1;
        }

        var hitungan = setInterval(function () {
            angkaSekarang = angkaSekarang + tambahan;

            if (angkaSekarang >= angkaTujuan) {
                angkaSekarang = angkaTujuan;
                clearInterval(hitungan);
            }

            elemenAngka.text(angkaSekarang);
        }, 30);
    });

    // validasi satu kolom form
    function cekKolom(kolom) {
        var nilai = $.trim(kolom.val());
        var namaKolom = kolom.attr('name');
        var pesanError = '';

        if (kolom.prop('required') && nilai == '') {
            pesanError = 'Kolom ini harus diisi.';
        } else if (namaKolom == 'email' && nilai != '' && nilai.indexOf('@') == -1) {
            pesanError = 'Email harus memakai tanda @.';
        } else if (namaKolom == 'telepon' && nilai != '' && !/^[0-9+]{9,15}$/.test(nilai)) {
            pesanError = 'Telepon harus 9 sampai 15 angka.';
        } else if (namaKolom == 'nama' && nilai != '' && nilai.length < 3) {
            pesanError = 'Nama minimal 3 huruf.';
        }

        // hapus pesan lama sebelum dicek ulang
        kolom.next('.invalid-feedback').remove();
        kolom.removeClass('is-invalid');

        if (pesanError != '') {
            kolom.addClass('is-invalid');
            kolom.after('<div class="invalid-feedback">' + pesanError + '</div>');
            return false;
        }

        return true;
    }

    // cek semua kolom ketika form dikirim
    $('form.cek-form').on('submit', function (event) {
        var semuaBenar = true;

        $(this).find('input, select, textarea').not('[type=hidden]').each(function () {
            if (!cekKolom($(this))) {
                semuaBenar = false;
            }
        });

        if (!semuaBenar) {
            event.preventDefault();
            $(this).find('.is-invalid').first().focus();
        }
    });

    // cek ulang ketika pengguna sedang mengetik
    $('form.cek-form').on('input change', 'input, select, textarea', function () {
        cekKolom($(this));
    });

    // hapus data memakai ajax, halaman tidak perlu dimuat ulang
    $('form.form-hapus').on('submit', function (event) {
        event.preventDefault();

        var formHapus = $(this);
        var yakin = confirm('Yakin mau menghapus ' + formHapus.data('nama') + '?');

        if (!yakin) {
            return;
        }

        $.ajax({
            url: formHapus.attr('action'),
            method: 'POST',
            data: formHapus.serialize(),
            success: function () {
                formHapus.closest('tr').fadeOut(300, function () {
                    $(this).remove();
                });
            },
            error: function (xhr) {
                var pesan = 'Gagal menghapus.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    pesan = xhr.responseJSON.message;
                }

                alert(pesan);
            }
        });
    });

    // kolom pencarian di atas tabel
    $('#cari').on('keyup', function () {
        var kataKunci = $(this).val().toLowerCase();

        $('#tabel tbody tr').each(function () {
            var isiBaris = $(this).text().toLowerCase();

            if (isiBaris.indexOf(kataKunci) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

});
