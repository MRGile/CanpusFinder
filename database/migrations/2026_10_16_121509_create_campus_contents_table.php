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
        Schema::create('campus_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
            $table->string('kind', 30);
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('value')->nullable();
            $table->string('icon', 20)->nullable();
            $table->string('color', 20)->nullable();
            $table->string('text_color', 20)->nullable();
            $table->unsignedInteger('metric')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->index(['campus_id', 'kind', 'sort_order']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campus_contents');
    }
};
