<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BetaInviteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            \App\Models\BetaInvite::create([
                'code' => strtoupper(\Illuminate\Support\Str::random(10)),
                'is_active' => false,
            ]);
        }

        \App\Models\Setting::set('registration_enabled', '1');
    }
}
