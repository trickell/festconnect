<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('moderation_flags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('moderator_id');
            $table->unsignedBigInteger('target_id');
            $table->enum('target_type', ['post', 'user']);
            $table->enum('type', ['good', 'bad', 'warning']);
            $table->text('reason');
            $table->enum('status', ['pending', 'cleared', 'warned', 'removed'])->default('pending');
            $table->text('admin_comment')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();

            $table->foreign('moderator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moderation_flags');
    }
};
