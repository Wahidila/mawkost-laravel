<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('kost_facility', function (Blueprint $table) {
            $table->foreignId('kost_id')->constrained('kosts')->onDelete('cascade');
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            $table->string('label')->nullable();
            $table->primary(['kost_id', 'facility_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kost_facility');
    }
};
