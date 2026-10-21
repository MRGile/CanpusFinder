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
        Schema::create('campuses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('abbreviation', 20);
            $table->string('name');
            $table->string('city');
            $table->string('type');
            $table->string('accreditation')->default('Unggul');
            $table->unsignedInteger('program_count')->default(0);
            $table->decimal('rating', 2, 1)->default(0);
            $table->unsignedInteger('review_count')->default(0);
            $table->string('rank')->nullable();
            $table->string('logo_color', 20)->default('#EFF6FF');
            $table->string('logo_text_color', 20)->default('#1D4ED8');
            $table->string('cover_gradient', 120)->default('linear-gradient(135deg,#1E3A5F,#1D4ED8)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campuses');
    }
};
