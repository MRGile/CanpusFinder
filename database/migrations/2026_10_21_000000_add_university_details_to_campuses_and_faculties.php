<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campuses', function (Blueprint $table) {
            $table->string('province')->nullable()->after('city');
            $table->text('address')->nullable()->after('province');
            $table->string('website')->nullable()->after('address');
            $table->string('email')->nullable()->after('website');
            $table->string('phone', 40)->nullable()->after('email');
            $table->unsignedSmallInteger('founded_year')->nullable()->after('phone');
            $table->text('description')->nullable()->after('founded_year');
        });

        Schema::table('faculties', function (Blueprint $table) {
            $table->string('dean')->nullable()->after('name');
            $table->string('email')->nullable()->after('dean');
            $table->string('phone', 40)->nullable()->after('email');
            $table->string('website')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->dropColumn(['dean', 'email', 'phone', 'website']);
        });

        Schema::table('campuses', function (Blueprint $table) {
            $table->dropColumn(['province', 'address', 'website', 'email', 'phone', 'founded_year', 'description']);
        });
    }
};
