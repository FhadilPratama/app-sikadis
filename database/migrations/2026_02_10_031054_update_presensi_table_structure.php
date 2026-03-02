<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            // Drop existing enum first (MySQL specific logic needed usually, 
            // but Laravel 10+ handles change() well for some types. 
            // For enum, safe way is dropping constraint or modifying column raw.)

            // To be safe and compatible: 
            // 1. Add new columns
            // 2. Modify enum using raw SQL because Doctrine/DBAL has issues with Enums often.
        });

        // Modifying ENUM directly
        DB::statement("ALTER TABLE presensi MODIFY COLUMN status ENUM('hadir', 'terlambat', 'izin', 'sakit', 'alpha') NOT NULL DEFAULT 'hadir'");

        Schema::table('presensi', function (Blueprint $table) {
            $table->time('jam_pulang')->nullable()->after('jam_masuk');
            $table->string('keterangan')->nullable()->after('status');
            $table->enum('sumber_presensi', ['siswa', 'wali_kelas', 'admin'])
                ->default('siswa')
                ->after('keterangan');

            // Adding creator/updater ID for tracking manual inputs
            $table->unsignedBigInteger('created_by')->nullable()->after('updated_at');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            $table->dropColumn(['jam_pulang', 'keterangan', 'sumber_presensi', 'created_by', 'updated_by']);
        });

        DB::statement("ALTER TABLE presensi MODIFY COLUMN status ENUM('hadir', 'terlambat') NOT NULL");
    }
};
