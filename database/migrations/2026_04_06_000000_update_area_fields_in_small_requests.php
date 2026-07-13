<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('small_requests', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['area_allotee', 'area_buyer']);

            // Add new columns
            $table->decimal('area_per_sqft', 10, 2)->nullable()->after('engineer_stamp_signature');
            $table->decimal('total_amount', 10, 2)->nullable()->after('area_per_sqft');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('small_requests', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['area_per_sqft', 'total_amount']);

            // Add back old columns
            $table->decimal('area_allotee', 10, 2)->nullable()->after('engineer_stamp_signature');
            $table->decimal('area_buyer', 10, 2)->nullable()->after('area_allotee');
        });
    }
};
