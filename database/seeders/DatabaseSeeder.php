<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $kataSandi = 'kasbon12345';

        // =====================================
        // DATA USER / AKUN LOGIN
        // =====================================

        User::updateOrCreate(
            ['email' => 'budi@manajer.koperasi'],
            [
                'name' => 'Budi Santoso',
                'password' => $kataSandi,
            ]
        );

        User::updateOrCreate(
            ['email' => 'siti@admin.koperasi'],
            [
                'name' => 'Siti Aminah',
                'password' => $kataSandi,
            ]
        );

        // =====================================
        // DATA ANGGOTA
        // =====================================

        $dataAnggota = [
            [
                'AGT-0001',
                'Slamet Riyadi',
                '081325647012',
                '2022-01-10',
                'Dsn. Krajan RT 03 RW 01, Kromengan',
            ],
            [
                'AGT-0002',
                'Wati Susanti',
                '085731246908',
                '2022-02-22',
                'Dsn. Sumberejo RT 02 RW 04, Kromengan',
            ],
            [
                'AGT-0003',
                'Bambang Irawan',
                '081217845536',
                '2022-05-17',
                'Jl. Raya Ngajum No. 30, Ngajum',
            ],
        ];

        foreach ($dataAnggota as $baris) {
            Anggota::updateOrCreate(
                ['nomor_anggota' => $baris[0]],
                [
                    'nama' => $baris[1],
                    'telepon' => $baris[2],
                    'tanggal_gabung' => $baris[3],
                    'status' => 'aktif',
                    'alamat' => $baris[4],
                ]
            );
        }

        // =====================================
        // DATA PEGAWAI
        // =====================================

        $dataPegawai = [
            [
                '234567',
                'Danu',
                'danu@pegawai.koperasi',
                '081234567001',
                'Magang',
                'SO',
                '2026-08-24',
                'Jl. Raya Kromengan, Malang',
                'aktif',
            ],
            [
                '234568',
                'Andi Saputra',
                'andi@pegawai.koperasi',
                '081234567002',
                'Manager',
                'Keuangan',
                '2020-01-10',
                'Jl. Merdeka No. 12, Malang',
                'aktif',
            ],
            [
                '234569',
                'Rina Aprilia',
                'rina@pegawai.koperasi',
                '081234567003',
                'Admin',
                'Administrasi',
                '2021-03-15',
                'Jl. Diponegoro No. 15, Malang',
                'aktif',
            ],
            [
                '234570',
                'Bambang Pratama',
                'bambang@pegawai.koperasi',
                '081234567004',
                'Staff',
                'Operasional',
                '2022-05-20',
                'Jl. Ahmad Yani No. 20, Malang',
                'aktif',
            ],
            [
                '234571',
                'Siti Nurhaliza',
                'siti@pegawai.koperasi',
                '081234567005',
                'Staff',
                'Keuangan',
                '2023-02-01',
                'Jl. Soekarno Hatta No. 10, Malang',
                'aktif',
            ],
            [
                '234572',
                'Agus Setiawan',
                'agus@pegawai.koperasi',
                '081234567006',
                'Supervisor',
                'Operasional',
                '2019-07-12',
                'Jl. Ijen No. 8, Malang',
                'aktif',
            ],
            [
                '234573',
                'Dewi Anggraini',
                'dewi@pegawai.koperasi',
                '081234567007',
                'Admin',
                'Pelayanan',
                '2022-09-05',
                'Jl. Tlogomas No. 25, Malang',
                'aktif',
            ],
        ];

        foreach ($dataPegawai as $baris) {
            Pegawai::updateOrCreate(
                ['nip' => $baris[0]],
                [
                    'nama' => $baris[1],
                    'email' => $baris[2],
                    'telepon' => $baris[3],
                    'jabatan' => $baris[4],
                    'departemen' => $baris[5],
                    'tanggal_masuk' => $baris[6],
                    'alamat' => $baris[7],
                    'status' => $baris[8],
                ]
            );
        }
    }
}
