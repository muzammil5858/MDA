<?php
require 'vendor/autoload.php';
$app = require_once('bootstrap/app.php');
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$types = DB::table('request_types')->get();
foreach ($types as $type) {
    echo "ID: " . $type->id . " - Name: " . $type->name . PHP_EOL;
}
