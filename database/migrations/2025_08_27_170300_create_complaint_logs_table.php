<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('action', ['created', 'assigned', 'status_changed', 'note']);
            $table->text('message')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->index(['complaint_id', 'action']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_logs');
    }
};


