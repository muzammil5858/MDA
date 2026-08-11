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
        Schema::table('attchements', function (Blueprint $table) {
            $table->integer('complete_file_pages')->nullable()->after('complete_property_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attchements', function (Blueprint $table) {
            $table->dropColumn('complete_file_pages');
        });
    }
};
