<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Алексей',
            'email' => 'zales@tut.by',
        ]);

        \App\Models\Product::factory(100)->create();
    }
}
