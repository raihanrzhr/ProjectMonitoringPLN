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
        Schema::create('units', function (Blueprint $table) {
            $table->increments('unit_id');
            $table->string('nama_unit', 100)
                ->comment('e.g., UPS Mobile U-01');
            $table->enum('tipe_peralatan', ['UPS', 'UKB', 'DETEKSI']);

            $table->string('nopol', 15)->unique();
            $table->string('merk_kendaraan', 50)->nullable();
            $table->string('tipe_kendaraan', 50)->nullable();
            $table->enum('kondisi_kendaraan', ['BAIK', 'DIGUNAKAN', 'RUSAK', 'PERBAIKAN'])
                ->default('BAIK');
            $table->enum('status', ['Standby', 'Digunakan', 'Tidak Siap Oprasi'])
                ->default('Standby');
            $table->string('lokasi', 255)->nullable();
            $table->text('catatan')->nullable();

            // Info Kendaraan
            $table->date('tgl_service_terakhir')->nullable();
            // Info Legalitas Kendaraan
            $table->boolean('status_bpkb')->nullable();
            $table->boolean('status_stnk')->nullable();
            $table->date('pajak_tahunan')->nullable();
            $table->date('pajak_5tahunan')->nullable();
            $table->boolean('status_kir')->nullable();
            $table->date('masa_berlaku_kir')->nullable();
            $table->string('dokumentasi', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
