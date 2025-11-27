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
        Schema::create('detail_deteksi', function (Blueprint $table) {
            $table->unsignedInteger('unit_id')->primary();
            $table->string('fitur', 255)->nullable();
            $table->string('type', 50)->nullable(); //->comment('Contoh: MOBIL');

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
        Schema::dropIfExists('detail_deteksi');
    }
};
