<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $kosts = \App\Models\Kost::all();
        foreach ($kosts as $kost) {
            $kost->update([
                'slug' => \Illuminate\Support\Str::slug($kost->title) . '-' . \Illuminate\Support\Str::random(5),
            ]);
        }
    }

    public function down(): void
    {
    }
};
