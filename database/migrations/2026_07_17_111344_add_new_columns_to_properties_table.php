<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {

            $table->string('application_no')->nullable();
            $table->date('application_date')->nullable();

            $table->string('plot_no')->nullable();
            $table->string('sector')->nullable();
            $table->string('block')->nullable();

            $table->string('kanal')->nullable();
            $table->string('marla')->nullable();
            $table->string('sqrft')->nullable();

            $table->string('approved_scheme')->nullable();

            $table->decimal('initial_draft_amount',15,2)->nullable();
            $table->date('initial_draft_date')->nullable();

            $table->string('applicant_name')->nullable();
            $table->string('father_husband_name')->nullable();
            $table->string('old_nic')->nullable();
            $table->string('cnic')->nullable();

            $table->text('address_temporary')->nullable();
            $table->text('address_permanent')->nullable();

            $table->string('category')->nullable();

            $table->string('mode_allottment')->nullable();

            $table->date('allotment_date')->nullable();

            $table->string('balloting_serial_no')->nullable();

        });
    }

    public function down(): void
    {
        //
    }
};
