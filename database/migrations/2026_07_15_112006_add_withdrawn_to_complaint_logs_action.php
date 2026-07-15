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
        Schema::table('complaint_logs', function (Blueprint $table) {
            $table->string('action')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaint_logs', function (Blueprint $table) {
            // Note: Reversing this might cause data loss if there are 'withdrawn' actions
            // SQLite ENUM is technically just a string check constraint, so we leave it as string.
        });
    }
};
