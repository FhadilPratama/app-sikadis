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
        Schema::create('izin_kehadiran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('anggota_rombel_id')
                ->constrained('anggota_rombel')
                ->cascadeOnDelete();

            $table->date('tanggal');

            $table->enum('jenis', ['sakit', 'izin', 'alpa']);

            $table->text('keterangan')->nullable();
            $table->string('bukti')->nullable();

            $table->enum('status', ['pending', 'disetujui', 'ditolak'])
                ->default('pending');

            $table->timestamps();

            $table->unique(
                ['anggota_rombel_id', 'tanggal'],
                'uniq_izin_per_hari'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_kehadiran');
    }
};
