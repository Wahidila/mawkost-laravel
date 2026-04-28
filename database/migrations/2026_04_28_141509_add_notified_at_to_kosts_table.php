<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->timestamp('notified_at')->nullable()->after('purchase_count');
        });
    }

    public function down(): void
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->dropColumn('notified_at');
        });
    }
};
