<?php
require 'vendor/autoload.php';
$app = require_once('bootstrap/app.php');
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$exists = DB::table('request_types')->where('id', 4)->first();

if (!$exists) {
    DB::table('request_types')->insert([
        'id' => 4,
        'name' => 'House Construction Permission',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "Added 'House Construction Permission' to request_types table." . PHP_EOL;
} else {
    echo "'House Construction Permission' already exists in request_types table." . PHP_EOL;
}
