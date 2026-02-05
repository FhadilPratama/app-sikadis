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
        Schema::create('wali_kelas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('rombongan_belajar_id')
                ->constrained('rombongan_belajar')
                ->cascadeOnDelete();

            $table->foreignId('tahun_ajar_id')
                ->constrained('tahun_ajar');

            $table->boolean('active')->default(true);

            $table->timestamps();

            $table->unique([
                'rombongan_belajar_id',
                'tahun_ajar_id'
            ], 'uniq_wali_rombel_tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_kelas');
    }
};
