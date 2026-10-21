<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campuses', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('image_path');
        });

        Schema::create('campus_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('body');
            $table->timestamps();
            $table->unique(['campus_id', 'user_id']);
            $table->index(['campus_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campus_reviews');

        Schema::table('campuses', function (Blueprint $table) {
            $table->dropColumn('logo_path');
        });
    }
};
