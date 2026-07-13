<?php
require 'vendor/autoload.php';
$app = require_once('bootstrap/app.php');
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

if (!Schema::hasTable('small_requests')) {
    Schema::create('small_requests', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('property_id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('request_id');
        $table->boolean('all_documents_verified')->default(0);
        $table->string('architect_name')->nullable();
        $table->string('architect_address')->nullable();
        $table->string('architect_stamp_signature')->nullable();
        $table->string('engineer_name')->nullable();
        $table->string('engineer_address')->nullable();
        $table->string('engineer_stamp_signature')->nullable();
        $table->string('approved_map')->nullable();
        $table->timestamps();

        // Foreign keys - only if the referenced tables exist
        if (Schema::hasTable('properties')) {
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        }
        if (Schema::hasTable('users')) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        }
        if (Schema::hasTable('requests')) {
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
        }
    });
    echo "Table 'small_requests' created successfully." . PHP_EOL;
} else {
    echo "Table 'small_requests' already exists." . PHP_EOL;
}
