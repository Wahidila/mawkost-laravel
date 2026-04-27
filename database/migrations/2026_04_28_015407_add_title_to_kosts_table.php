<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->string('title')->after('kode');
        });

        // Copy existing name values to title as default
        DB::statement('UPDATE kosts SET title = name');
    }

    public function down(): void
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
};
