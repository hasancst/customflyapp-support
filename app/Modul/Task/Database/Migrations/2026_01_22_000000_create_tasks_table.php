<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            
            // Core Details
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'blocked', 'review', 'done', 'cancelled'])->default('pending')->index();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->index();
            
            // Ownership & Assignment
            $table->foreignId('assigned_to')->nullable()->constrained('pengguna')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('pengguna')->nullOnDelete();
            $table->foreignId('team_id')->nullable(); // For Team assignment
            
            // Relationships (Polymorphic or Direct)
            $table->foreignId('tiket_id')->nullable()->constrained('tikets')->nullOnDelete();
            $table->integer('chat_session_id')->nullable()->index(); // Assuming chat ID is integer
            $table->foreignId('parent_task_id')->nullable()->constrained('tasks')->nullOnDelete();
            
            // Timing & SLA
            $table->timestamp('due_at')->nullable();
            $table->timestamp('sla_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            // AI Integration
            $table->boolean('is_ai_generated')->default(false);
            $table->json('ai_metadata')->nullable(); // Stores reasoning, confidence score, original intent
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('task_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('pengguna');
            $table->string('action'); // 'created', 'status_change', 'comment', 'sla_breach'
            $table->text('details')->nullable();
            $table->json('changes')->nullable(); // Before/After values
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_activities');
        Schema::dropIfExists('tasks');
    }
};
