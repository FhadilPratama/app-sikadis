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
            $table->json('descriptor')->after('face_id')->nullable();
            $table->string('image_path')->after('descriptor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('face_data', function (Blueprint $table) {
            $table->dropColumn(['descriptor', 'image_path']);
        });
    }
};
