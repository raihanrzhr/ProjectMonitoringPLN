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
        Schema::create('detail_ukb', function (Blueprint $table) {
            $table->unsignedInteger('unit_id')->primary();
            $table->string('jenis_ukb', 50)->nullable(); // mobile, karavan
            $table->string('type', 50)->nullable(); // ->comment('Contoh: 1C X 60SQMM');
            $table->integer('panjang_kabel_m')->nullable();
            $table->string('kabel', 50)->nullable(); // ->comment('Contoh: 150 mm');
            $table->string('volume', 50)->nullable(); // ->comment('Contoh: 1 atau 2 set');

            $table->foreign('unit_id')
                ->references('unit_id')
                ->on('units')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_ukb');
    }
};
