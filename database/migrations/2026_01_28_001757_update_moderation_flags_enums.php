<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite doesn't support enum modification easily. 
        // We will handle data integrity in the application layer.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
