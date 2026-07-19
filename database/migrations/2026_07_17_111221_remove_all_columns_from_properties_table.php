<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {

            $table->dropColumn([
                'category',
                'kanal',
                'marla',
                'sqrft',
                'sector',
                'plot_no',
                'cnic',
                'application_no',
                'application_date',
                'block',
                'approved_scheme',
                'initial_draft_amount',
                'initial_draft_date',
                'applicant_name',
                'father_husband_name',
                'old_nic',
                'address_temporary',
                'address_permanent',
                'mode_allottment',
                'allotment_date',
                'balloting_serial_no',
            ]);

        });
    }

    public function down(): void
    {
        //
    }
};
