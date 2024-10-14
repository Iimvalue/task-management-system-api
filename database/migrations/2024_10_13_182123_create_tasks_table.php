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
            $table->string("title");
            $table->string("description")->nullable();
            $table->enum('assign_status', ["Assigned", "Not Assigned"])->default('Not Assigned');
            $table->enum('resolve_status', ["Resolved", "Not Resolved"])->default('Not Resolved');
            $table->text('notes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId("created_by")->constrained('users')->onDelete('cascade');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
