<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->date('deadline')->nullable()->after('amount');
        });

        DB::table('scholarships')->select(['id', 'deadline_label'])->orderBy('id')->chunk(100, function ($scholarships) {
            foreach ($scholarships as $scholarship) {
                try {
                    $deadline = Carbon::parseFromLocale($scholarship->deadline_label, 'id')->toDateString();
                } catch (\Throwable) {
                    try {
                        $deadline = Carbon::parse($scholarship->deadline_label)->toDateString();
                    } catch (\Throwable) {
                        continue;
                    }
                }

                DB::table('scholarships')->where('id', $scholarship->id)->update(['deadline' => $deadline]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropColumn('deadline');
        });
    }
};
