<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('voucher_id')->nullable()->after('xendit_payment_channel')->constrained()->onDelete('set null');
            $table->integer('discount_amount')->default(0)->after('voucher_id');
            $table->integer('original_amount')->nullable()->after('discount_amount');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['voucher_id']);
            $table->dropColumn(['voucher_id', 'discount_amount', 'original_amount']);
        });
    }
};
