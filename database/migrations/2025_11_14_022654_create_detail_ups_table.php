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
        Schema::create('detail_ups', function (Blueprint $table) {
            $table->unsignedInteger('unit_id')->primary();
            $table->decimal('kapasitas_kva', 10, 2)->nullable();
            $table->string('jenis_ups', 50)->nullable(); // mobile, portable
            $table->string('batt_merk', 50)->nullable();
            $table->integer('batt_jumlah')->nullable();
            $table->string('batt_kapasitas', 50)->nullable();
            $table->string('model_no_seri', 255)->nullable(); // Format: MODEL / NO_SERI

            $table->foreign('unit_id')
                ->references('unit_id')
                ->on('unit_mobiles')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_ups');
    }
};
