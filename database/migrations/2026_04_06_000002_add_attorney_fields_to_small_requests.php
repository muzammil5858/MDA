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
            $table->enum('representation_type', ['self', 'attorney'])->default('self')->after('total_amount');
            $table->string('attorney_name')->nullable()->after('representation_type');
            $table->string('attorney_father_name')->nullable()->after('attorney_name');
            $table->string('attorney_cnic', 15)->nullable()->after('attorney_father_name');
            $table->text('attorney_address')->nullable()->after('attorney_cnic');
            $table->string('attorney_cnic_front')->nullable()->after('attorney_address');
            $table->string('attorney_cnic_back')->nullable()->after('attorney_cnic_front');
            $table->string('attorney_letter')->nullable()->after('attorney_cnic_back');
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
            $table->dropColumn([
                'representation_type',
                'attorney_name',
                'attorney_father_name',
                'attorney_cnic',
                'attorney_address',
                'attorney_cnic_front',
                'attorney_cnic_back',
                'attorney_letter'
            ]);
        });
    }
};
