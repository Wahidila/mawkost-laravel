<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->enum('type', ['putra', 'putri', 'campur']);
            $table->integer('price');
            $table->text('description')->nullable();
            $table->string('area_label')->nullable();
            $table->integer('available_rooms')->default(0);
            $table->integer('total_rooms')->nullable();
            $table->integer('total_bathrooms')->nullable();
            $table->enum('status', ['tersedia', 'penuh'])->default('tersedia');
            $table->string('floor_count')->nullable();
            $table->string('parking_type')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_recommended')->default(false);
            $table->integer('unlock_price')->default(15000);
            $table->text('address')->nullable();
            $table->string('owner_contact')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('maps_link')->nullable();
            $table->integer('purchase_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};
