<?php
// database/migrations/2026_08_19_080003_rename_columns_in_attchements_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('attchements', function (Blueprint $table) {
            // Rename division_of_plots to allotment_order
            $table->renameColumn('division_of_plots', 'allotment_order');

            // Rename complete_property_file to property_document
            $table->renameColumn('complete_property_file', 'property_document');
        });
    }

    public function down()
    {
        Schema::table('attchements', function (Blueprint $table) {
            // Reverse the renames
            $table->renameColumn('allotment_order', 'division_of_plots');
            $table->renameColumn('property_document', 'complete_property_file');
        });
    }
};
