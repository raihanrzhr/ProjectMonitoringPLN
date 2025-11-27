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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->increments('peminjaman_id');
            $table->unsignedInteger('unit_id');

            // mengikuti tabel users
            $table->unsignedBigInteger('user_id_pemohon')->nullable();

            $table->dateTime('tgl_mobilisasi');
            $table->dateTime('tgl_event_mulai')->nullable();
            $table->dateTime('tgl_event_selesai')->nullable();
            $table->dateTime('tgl_demobilisasi')->nullable();
            $table->string('kegiatan', 255);
            $table->string('Tamu_VIP', 255)->nullable();
            $table->string('lokasi_tujuan', 255);
            // $table->string('posko_pelaksana', 255)->nullable(); (masuknya table unit_id)
            $table->string('up3_id', 255)->nullable();
            $table->enum('status_peminjaman', ['Selesai', 'Cancel', 'Sedang Digunakan']);
            $table->text('keterangan')->nullable();

            $table->foreign('unit_id')
                ->references('unit_id')
                ->on('units');

            // foreign key ke users (TIPE WAJIB BIGINT)
            $table->foreign('user_id_pemohon')
                ->references('id')
                ->on('users');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
