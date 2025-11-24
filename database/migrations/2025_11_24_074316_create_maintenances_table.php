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
        Schema::create('maintenance', function (Blueprint $table) {
            $table->increments('perbaikan_id');
            $table->unsignedInteger('laporan_id')->unique()->nullable();
            $table->unsignedInteger('unit_id'); // relasi ke unit_mobile
            $table->string('item_pekerjaan', 255);
            $table->string('no_notdin', 100)->nullable();
            $table->date('tgl_notdin')->nullable();
            $table->boolean('status_acc_ku')->default(false);
            $table->date('tgl_eksekusi')->nullable();
            $table->decimal('nilai_pekerjaan', 15, 2)->default(0.00);
            $table->text('keterangan')->nullable();

            $table->foreign('laporan_id')
                ->references('laporan_id')
                ->on('reports');
            $table->foreign('unit_id')
                ->references('unit_id')
                ->on('units');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
