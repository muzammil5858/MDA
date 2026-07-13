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
        Schema::table('requests', function (Blueprint $table) {
            $table->string('clerk_action')->nullable()->after('dd_action');
            $table->text('clerk_remarks')->nullable()->after('clerk_action');
            $table->timestamp('clerk_action_date')->nullable()->after('clerk_remarks');
            $table->unsignedBigInteger('clerk_id')->nullable()->after('clerk_action_date');
            $table->foreign('clerk_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign(['clerk_id']);
            $table->dropColumn(['clerk_action', 'clerk_remarks', 'clerk_action_date', 'clerk_id']);
        });
    }
};
