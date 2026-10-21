<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->whereNull('role')->update(['role' => 'pengguna']);
        DB::table('users')->whereNotIn('role', ['admin', 'pengguna'])->update(['role' => 'pengguna']);
    }

    public function down(): void
    {
    }
};
