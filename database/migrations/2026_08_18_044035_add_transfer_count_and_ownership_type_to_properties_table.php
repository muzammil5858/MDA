<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->integer('transfer_count')->nullable()->after('balloting_serial_no');
            $table->enum('ownership_type', ['single', 'multiple'])->nullable()->after('transfer_count');
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['transfer_count', 'ownership_type']);
        });
    }
};
