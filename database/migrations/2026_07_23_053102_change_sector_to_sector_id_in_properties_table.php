<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Pehle purani foreign key ho to remove karein
        Schema::table('properties', function (Blueprint $table) {
            // Agar sector column par foreign key nahi hai to is line ko remove kar dein
           //  $table->dropForeign(['sector']);
        });

        // Column rename karein
        Schema::table('properties', function (Blueprint $table) {
            $table->renameColumn('sector', 'sector_id');
        });

        // Datatype change karein
        DB::statement('ALTER TABLE properties MODIFY sector_id BIGINT UNSIGNED NULL');

        // Foreign Key add karein
        Schema::table('properties', function (Blueprint $table) {
            $table->foreign('sector_id')
                  ->references('id')
                  ->on('sectors')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['sector_id']);
        });

        DB::statement('ALTER TABLE properties MODIFY sector_id VARCHAR(255) NULL');

        Schema::table('properties', function (Blueprint $table) {
            $table->renameColumn('sector_id', 'sector');
        });
    }
};
