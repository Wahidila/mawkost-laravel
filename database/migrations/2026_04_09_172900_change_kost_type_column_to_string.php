<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration 
{
    public function up(): void
    {
        // Change the 'type' enum column to a nullable string so it can accept
        // any kost type slug (e.g. 'pasutri') instead of only 'putra','putri','campur'.
        DB::statement("ALTER TABLE kosts MODIFY COLUMN `type` VARCHAR(255) NULL DEFAULT NULL");
    }

    public function down(): void
    {
        // Revert back to enum (data that doesn't fit will be truncated)
        DB::statement("ALTER TABLE kosts MODIFY COLUMN `type` ENUM('putra','putri','campur') NOT NULL DEFAULT 'campur'");
    }
};
