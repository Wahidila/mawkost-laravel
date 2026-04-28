<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::where('role', 'user')->delete();
        Schema::enableForeignKeyConstraints();

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'whatsapp' => '081234567890',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Sari Dewi',
            'email' => 'sari@example.com',
            'whatsapp' => '089876543210',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);
    }
}
