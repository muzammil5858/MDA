<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Step 1: Renames
        Schema::table('attchements', function (Blueprint $table) {
            if (Schema::hasColumn('attchements', 'division_of_plots') && !Schema::hasColumn('attchements', 'allotment_order')) {
                $table->renameColumn('division_of_plots', 'allotment_order');
            }
        });

        Schema::table('attchements', function (Blueprint $table) {
            if (Schema::hasColumn('attchements', 'complete_property_file') && !Schema::hasColumn('attchements', 'property_document')) {
                $table->renameColumn('complete_property_file', 'property_document');
            }
        });

        // Step 2: Add new columns after the renamed columns
        Schema::table('attchements', function (Blueprint $table) {
            if (!Schema::hasColumn('attchements', 'noting_file')) {
                $table->string('noting_file')->nullable()->after('property_document');
            }
            if (!Schema::hasColumn('attchements', 'cnic_front')) {
                $table->string('cnic_front')->nullable()->after('noting_file');
            }
        });
    }

    public function down()
    {
        Schema::table('attchements', function (Blueprint $table) {
            if (Schema::hasColumn('attchements', 'noting_file') || Schema::hasColumn('attchements', 'cnic_front')) {
                $table->dropColumn(array_filter(['noting_file', 'cnic_front'], fn($col) => Schema::hasColumn('attchements', $col)));
            }
        });

        Schema::table('attchements', function (Blueprint $table) {
            if (Schema::hasColumn('attchements', 'property_document')) {
                $table->renameColumn('property_document', 'complete_property_file');
            }
        });

        Schema::table('attchements', function (Blueprint $table) {
            if (Schema::hasColumn('attchements', 'allotment_order')) {
                $table->renameColumn('allotment_order', 'division_of_plots');
            }
        });
    }
};
