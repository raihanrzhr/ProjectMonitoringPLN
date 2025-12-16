<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('laporan_id');

            // Sesuaikan tipe FK dengan tabel lain
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('peminjaman_id');
            $table->unsignedBigInteger('user_id_pelapor');

            $table->dateTime('tgl_kejadian');
            $table->string('lokasi_penggunaan', 255)->nullable();
            $table->text('deskripsi_kerusakan');
            // $table->enum('status_laporan', ['BARU', 'DIPERIKSA', 'PERBAIKKAN', 'SELESAI']);
            $table->string('no_ba', 100)->nullable();
            $table->decimal('keperluan_anggaran', 15, 2)->nullable();
            $table->string('up3', 255)->nullable();

            // Foreign keys
            $table->foreign('unit_id')->references('unit_id')->on('units');
            $table->foreign('user_id_pelapor')->references('id')->on('users');
            $table->foreign('peminjaman_id')->references('peminjaman_id')->on('peminjaman');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
        $table->dropForeign(['unit_id']); // atau nama kolom FK kamu
    });

    Schema::dropIfExists('reports');
    }
};
