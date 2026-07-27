<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $properties = DB::table('properties')
            ->whereNotNull('block')
            ->where('block', '!=', '')
            ->get();

        foreach ($properties as $property) {
            $block = DB::table('blocks')
                ->where('name', $property->block)
                ->where('sector_id', $property->sector_id)
                ->first();

            // Agar sector_id match na kare (purani data mismatch), sirf name se try karein
            if (!$block) {
                $block = DB::table('blocks')->where('name', $property->block)->first();
            }

            if ($block) {
                DB::table('properties')
                    ->where('id', $property->id)
                    ->update(['block_id' => $block->id]);
            }
        }
    }

    public function down(): void
    {
        // Reverse mein kuch nahi karna - block string column abhi bhi maujood hai
    }
};
