<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('izin_terlambat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('presensi_id')
                ->constrained('presensi')
                ->cascadeOnDelete();

            $table->text('keterangan')->nullable();
            $table->string('bukti')->nullable();

            $table->enum('status', ['pending', 'disetujui', 'ditolak'])
                ->default('pending');

            $table->timestamps();

            $table->unique('presensi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_terlambat');
    }
};
