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
        // Remove old columns
        Schema::table('attchements', function (Blueprint $table) {

            $table->dropColumn([
                'order_attach',
                'affected_house',
                'builtup_property',
                'entitlement',
                'allot_com',
                'allot_order',
                'chit_mapping',
            ]);
        });

        // Add new columns
        Schema::table('attchements', function (Blueprint $table) {

            $table->string('alternate_allotment')->nullable();

            // File paths
            $table->string('complete_property_file')->nullable();
            $table->string('adjacent_area_allotment')->nullable();
            $table->string('division_of_plots')->nullable();
            $table->string('decision_courts')->nullable();
            $table->string('decision_allotment_committee')->nullable();
            $table->string('decision_mda_board')->nullable();
            $table->string('decision_revising_authority')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attchements', function (Blueprint $table) {

            // Remove new columns
            $table->dropColumn([
                'alternate_allotment',
                'complete_property_file',
                'adjacent_area_allotment',
                'division_of_plots',
                'decision_courts',
                'decision_allotment_committee',
                'decision_mda_board',
                'decision_revising_authority',
            ]);

            // Restore old columns
            $table->string('order_attach')->nullable();
            $table->string('affected_house')->nullable();
            $table->string('builtup_property')->nullable();
            $table->string('entitlement')->nullable();
            $table->string('allot_com')->nullable();
            $table->string('allot_order')->nullable();
            $table->string('chit_mapping')->nullable();
        });
    }
};
