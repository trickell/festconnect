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
        Schema::create('beta_invites', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('email')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beta_invites');
    }
};
