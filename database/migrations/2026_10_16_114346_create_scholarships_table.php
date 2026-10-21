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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider');
            $table->string('scholarship_type');
            $table->string('amount');
            $table->string('deadline_label');
            $table->string('study_level');
            $table->string('emoji', 20)->default('🎓');
            $table->string('background_color', 20)->default('#DCFCE7');
            $table->string('text_color', 20)->default('#166534');
            $table->string('badge_color', 20)->default('#065F46');
            $table->string('recipient_count')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
