<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration 
{
    public function up(): void
    {
        // 1. Create the kost_types table
        Schema::create('kost_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 2. Insert default types
        DB::table('kost_types')->insert([
            ['name' => 'Putra', 'slug' => 'putra', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Putri', 'slug' => 'putri', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Campur', 'slug' => 'campur', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Add kost_type_id to kosts table
        Schema::table('kosts', function (Blueprint $table) {
            $table->unsignedBigInteger('kost_type_id')->nullable()->after('city_id');
        });

        // 4. Map the existing enums to the new foreign key
        $types = DB::table('kost_types')->get();
        foreach ($types as $type) {
            DB::table('kosts')->where('type', $type->slug)->update(['kost_type_id' => $type->id]);
        }

        // 5. Make kost_type_id not nullable and add foreign key constraint
        // Note: dropping enum columns in SQLite is not natively supported easily without full table rebuild,
        // so we'll keep the `type` column around (maybe nullable if MySQL, or just ignore it) but use `kost_type_id`.
        // To be safe, we just make kost_type_id foreign.
        Schema::table('kosts', function (Blueprint $table) {
            // If MySQL, we could drop the enum. For safety across DBs, we'll keep it but rely on kost_type_id.
            $table->foreign('kost_type_id')->references('id')->on('kost_types')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kosts', function (Blueprint $table) {
            $table->dropForeign(['kost_type_id']);
            $table->dropColumn('kost_type_id');
        });
        Schema::dropIfExists('kost_types');
    }
};
