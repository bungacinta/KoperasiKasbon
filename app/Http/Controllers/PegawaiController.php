<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use PDO;
use PDOException;

class PegawaiController extends Controller
{
    private function koneksi()
    {
        return DB::connection()->getPdo();
    }

    // HALAMAN DAFTAR PEGAWAI
    public function index()
    {
        return view('pegawai.index');
    }

    // MENGAMBIL DATA PEGAWAI
    public function data()
    {
        try {
            $pdo = $this->koneksi();

            $query = $pdo->prepare(
                "SELECT * FROM pegawai ORDER BY id DESC"
            );

            $query->execute();

            return response()->json([
                'sukses' => true,
                'data' => $query->fetchAll(PDO::FETCH_ASSOC)
            ]);

        } catch (PDOException $e) {
            report($e);

            return response()->json([
                'sukses' => false,
                'pesan' => 'Gagal mengambil data pegawai.'
            ], 500);
        }
    }

    // MENAMBAHKAN PEGAWAI
    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => 'required|max:30|unique:pegawai,nip',
            'nama' => 'required|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'email' => 'required|email|max:100|unique:pegawai,email',
            'telepon' => 'required|max:20',
            'jabatan' => 'required|max:100',
            'departemen' => 'required|max:100',
            'tanggal_masuk' => 'required|date',
            'alamat' => 'required',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        try {
            $pdo = $this->koneksi();

            $sql = "INSERT INTO pegawai
                (
                    nip, nama, jenis_kelamin, email, telepon,
                    jabatan, departemen, tanggal_masuk, alamat,
                    status, created_at, updated_at
                )
                VALUES
                (
                    :nip, :nama, :jenis_kelamin, :email, :telepon,
                    :jabatan, :departemen, :tanggal_masuk, :alamat,
                    :status, NOW(), NOW()
                )";

            $query = $pdo->prepare($sql);
            $query->execute($data);

            return response()->json([
                'sukses' => true,
                'pesan' => 'Pegawai berhasil ditambahkan.'
            ]);

        } catch (PDOException $e) {
            report($e);

            return response()->json([
                'sukses' => false,
                'pesan' => 'Gagal menambahkan pegawai.'
            ], 500);
        }
    }

    // DETAIL PEGAWAI
    public function show($id)
    {
        try {
            $pdo = $this->koneksi();

            $query = $pdo->prepare(
                "SELECT * FROM pegawai WHERE id = :id"
            );

            $query->execute(['id' => $id]);

            $pegawai = $query->fetch(PDO::FETCH_ASSOC);

            if (!$pegawai) {
                return response()->json([
                    'sukses' => false,
                    'pesan' => 'Pegawai tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'sukses' => true,
                'data' => $pegawai
            ]);

        } catch (PDOException $e) {
            report($e);

            return response()->json([
                'sukses' => false,
                'pesan' => 'Gagal mengambil detail pegawai.'
            ], 500);
        }
    }

    // UPDATE PEGAWAI
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nip' => [
                'required',
                'max:30',
                Rule::unique('pegawai', 'nip')->ignore($id)
            ],
            'nama' => 'required|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('pegawai', 'email')->ignore($id)
            ],
            'telepon' => 'required|max:20',
            'jabatan' => 'required|max:100',
            'departemen' => 'required|max:100',
            'tanggal_masuk' => 'required|date',
            'alamat' => 'required',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        try {
            $pdo = $this->koneksi();

            $data['id'] = $id;

            $sql = "UPDATE pegawai SET
                nip = :nip,
                nama = :nama,
                jenis_kelamin = :jenis_kelamin,
                email = :email,
                telepon = :telepon,
                jabatan = :jabatan,
                departemen = :departemen,
                tanggal_masuk = :tanggal_masuk,
                alamat = :alamat,
                status = :status,
                updated_at = NOW()
                WHERE id = :id";

            $query = $pdo->prepare($sql);
            $query->execute($data);

            $cek = $pdo->prepare(
                "SELECT id FROM pegawai WHERE id = :id"
            );

            $cek->execute(['id' => $id]);

            if (!$cek->fetch()) {
                return response()->json([
                    'sukses' => false,
                    'pesan' => 'Pegawai tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'sukses' => true,
                'pesan' => 'Data pegawai berhasil diperbarui.'
            ]);

        } catch (PDOException $e) {
            report($e);

            return response()->json([
                'sukses' => false,
                'pesan' => 'Gagal memperbarui pegawai.'
            ], 500);
        }
    }

    // HAPUS PEGAWAI
    public function destroy($id)
    {
        try {
            $pdo = $this->koneksi();

            $query = $pdo->prepare(
                "DELETE FROM pegawai WHERE id = :id"
            );

            $query->execute(['id' => $id]);

            if ($query->rowCount() === 0) {
                return response()->json([
                    'sukses' => false,
                    'pesan' => 'Pegawai tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'sukses' => true,
                'pesan' => 'Pegawai berhasil dihapus.'
            ]);

        } catch (PDOException $e) {
            report($e);

            return response()->json([
                'sukses' => false,
                'pesan' => 'Gagal menghapus pegawai.'
            ], 500);
        }
    }
}
