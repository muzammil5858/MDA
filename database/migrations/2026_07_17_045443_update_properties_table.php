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
        // ===========================
        // Remove old columns
        // ===========================
        Schema::table('properties', function (Blueprint $table) {

            $table->dropColumn([
                'district',
                'center',
                'locality',
                'code',
                'd_category',
                'dm_acre',
                'dm_kanal',
                'dm_marla',
                'dm_sqrft',
                'acre',
                'alotment_order',
                'town',
                'evacue_owner',
                'allotee_name',
                'relation',
                'de_date',
                'deo',
                'status',
                'remarks',
                'qa_id',
                'resolved',
                'allotment_type',
                'transfer_count',
                'qabza_chit',
                'map_approval',
                'house_constructed',
                'owner_type',
                'boundary_wall',
                'hiba_count',
                'sale_count',
                'warasat_count',
                'latest_transfer',
            ]);
        });

        // ===========================
        // Add new columns
        // ===========================
        Schema::table('properties', function (Blueprint $table) {

            $table->string('application_no')->nullable();
            $table->date('application_date')->nullable();

            $table->string('block')->nullable();

            $table->string('approved_scheme')->nullable();

            $table->decimal('initial_draft_amount', 15, 2)->nullable();
            $table->date('initial_draft_date')->nullable();

            $table->string('applicant_name')->nullable();
            $table->string('father_husband_name')->nullable();
            $table->string('old_nic')->nullable();

            $table->text('address_temporary')->nullable();
            $table->text('address_permanent')->nullable();

            $table->string('mode_allottment')->nullable();
            $table->date('allotment_date')->nullable();
            $table->string('balloting_serial_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
