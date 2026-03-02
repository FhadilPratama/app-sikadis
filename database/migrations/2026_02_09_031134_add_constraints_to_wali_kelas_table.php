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
        Schema::table('wali_kelas', function (Blueprint $table) {
            $table->unique(['user_id', 'tahun_ajar_id'], 'uniq_wali_user_tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wali_kelas', function (Blueprint $table) {
            $table->dropUnique('uniq_wali_user_tahun');
        });
    }
};
