<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::updateOrCreate(
            ['name' => 'systemadmin'],
            [
                'email' => 'admin@festconnect.com',
                'password' => Hash::make('sysADMIN123!'),
                'role' => 'admin'
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::where('name', 'systemadmin')->delete();
    }
};
