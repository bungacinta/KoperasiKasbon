@extends('layouts.app')

@section('title', 'Data Pegawai')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h3 class="fw-bold">Data Pegawai</h3>
            <p class="text-muted">Kelola data pegawai koperasi.</p>
        </div>

        <button type="button" class="btn btn-success"
                onclick="formTambah()">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Pegawai
        </button>
    </div>

    <div id="pesan"></div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="cariPegawai"
                           class="form-control"
                           placeholder="Cari NIP, nama, jabatan...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama Pegawai</th>
                            <th>Jabatan</th>
                            <th>Departemen</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="tabelPegawai">
                        <tr>
                            <td colspan="7" class="text-center">
                                Memuat data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

{{-- MODAL TAMBAH DAN EDIT --}}
<div class="modal fade" id="modalPegawai" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form id="formPegawai" class="modal-content" novalidate>

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="judulModal">
                    Tambah Pegawai
                </h5>

                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

                <div class="modal-body">

                    <input type="hidden" id="pegawai_id">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" id="nip"
                                   class="form-control" maxlength="30" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pegawai</label>
                            <input type="text" name="nama" id="nama"
                                   class="form-control" maxlength="100" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="form-select" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="telepon" id="telepon"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Departemen</label>
                            <input type="text" name="departemen" id="departemen"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk"
                                   id="tanggal_masuk" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="status"
                                    class="form-select" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat"
                                      class="form-control" rows="3" required></textarea>
                        </div>

                    </div>

                    <div id="errorValidasi" class="text-danger"></div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-success"
                            id="tombolSimpan">
                        <i class="bi bi-save me-1"></i>
                        Simpan Data
                    </button>

                </div>

            

        </form>
    </div>
</div>

{{-- MODAL DETAIL --}}
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Detail Pegawai</h5>

                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="isiDetail"></div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/pegawai.js') }}"></script>
@endpush