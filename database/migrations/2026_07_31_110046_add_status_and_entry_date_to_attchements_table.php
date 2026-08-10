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
            $table->boolean('status')->default(false)->after('alternate_allotment');
            $table->timestamp('entry_date')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attchements', function (Blueprint $table) {
            $table->dropColumn(['status', 'entry_date']);
        });
    }
};
