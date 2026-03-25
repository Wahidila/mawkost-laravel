<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->foreignId('kost_id')->constrained('kosts')->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_whatsapp');
            $table->string('customer_email');
            $table->integer('amount');
            $table->string('payment_method')->default('qris');
            $table->enum('status', ['pending', 'paid', 'expired', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
