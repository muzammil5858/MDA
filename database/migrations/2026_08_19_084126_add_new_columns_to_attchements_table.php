<?php
// database/migrations/2026_08_19_080001_add_new_columns_to_attchements_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('attchements', function (Blueprint $table) {
            $table->string('noting_file')->nullable()->after('property_document');
            $table->string('cnic_front')->nullable()->after('noting_file');
        });
    }

    public function down()
    {
        Schema::table('attchements', function (Blueprint $table) {
            $table->dropColumn(['noting_file', 'cnic_front']);
        });
    }
};
