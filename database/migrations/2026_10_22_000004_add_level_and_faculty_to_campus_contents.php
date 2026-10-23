<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campus_contents', function (Blueprint $table) {
            $table->string('study_level', 50)->nullable()->after('subtitle');
            $table->foreignId('faculty_id')->nullable()->after('study_level')->constrained('faculties')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('campus_contents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('faculty_id');
            $table->dropColumn('study_level');
        });
    }
};
