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
        Schema::table('face_data', function (Blueprint $table) {
            // Drop unique constraint on face_id first if it exists, or drop the column if not needed.
            // Assuming we want to drop it and use `angle` instead.
            $table->dropColumn('face_id');

            $table->enum('angle', ['front', 'left', 'right'])
                ->after('peserta_didik_id');

            // Add unique constraint per student per angle
            $table->unique(['peserta_didik_id', 'angle'], 'uniq_student_angle');

            // Allow multiple faces if needed, but for now 3 angles max
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('face_data', function (Blueprint $table) {
            $table->dropUnique('uniq_student_angle');
            $table->dropColumn('angle');
            $table->string('face_id')->unique()->nullable();
        });
    }
};
