<?php
// database/migrations/2026_08_19_080000_add_address_and_allottee_date_to_plot_histories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('plot_histories', function (Blueprint $table) {
            $table->text('address')->nullable()->after('challan_no');
            $table->date('allottee_date')->nullable()->after('address');
        });
    }

    public function down()
    {
        Schema::table('plot_histories', function (Blueprint $table) {
            $table->dropColumn(['address', 'allottee_date']);
        });
    }
};
