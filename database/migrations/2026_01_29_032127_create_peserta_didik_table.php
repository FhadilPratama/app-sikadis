<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peserta_didik', function (Blueprint $table) {
            $table->id();

            // relasi inti
            $table->foreignId('sekolah_id')
                ->constrained('sekolah')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // identitas dari API eksternal
            $table->uuid('peserta_didik_uuid')->unique();

            // identitas sekolah
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();

            // data utama
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();

            // status
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_didik');
    }
};
