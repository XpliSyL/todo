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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_structure_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('task_types_id')->constrained();
            $table->string('name');
            $table->text('details');
            $table->enum('status', ['draft', 'todo', 'waiting', 'done']);
            $table->date('due_date');
            $table->foreignId('contact_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
