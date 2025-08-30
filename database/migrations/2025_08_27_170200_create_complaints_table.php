<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->index();
            $table->enum('status', ['pending', 'in_progress', 'resolved', 'rejected'])->default('pending')->index();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['category_id', 'priority', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};


