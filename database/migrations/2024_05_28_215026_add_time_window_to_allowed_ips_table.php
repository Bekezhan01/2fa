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
        Schema::table('allowed_ips', function (Blueprint $table) {
            $table->time('time_window_start')->nullable();
            $table->time('time_window_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('allowed_ips', function (Blueprint $table) {
            $table->dropColumn('time_window_start');
            $table->dropColumn('time_window_end');
        });
    }
};
