
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migration.
     */
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();

            $table->string('nip', 30)->unique();
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', [
                'Laki-laki',
                'Perempuan'
            ]);

            $table->string('email', 100)->unique();
            $table->string('telepon', 20);

            $table->string('jabatan', 100);
            $table->string('departemen', 100);

            $table->date('tanggal_masuk');
            $table->text('alamat');

            $table->enum('status', [
                'Aktif',
                'Tidak Aktif'
            ])->default('Aktif');

            $table->timestamps();
        });
    }

    /**
     * Membatalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
