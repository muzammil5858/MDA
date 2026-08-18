<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('properties', 'allotment_type')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->enum('allotment_type', ['original', 'transferee'])->nullable()->after('ownership_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('allotment_type');
        });
    }
};
