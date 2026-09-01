<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class MigrateFilePaths extends Command
{
    protected $signature = 'files:migrate-paths {--dry-run}';
    protected $description = 'Move files to sector/block/... structure and update DB';
    protected $disk = 'public';

    public function handle()
    {
        $dryRun = $this->option('dry-run');

        // Create an on-demand logger specifically for this command
        $logger = Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/file_migration.log'),
        ]);

        $records = Property::with(['attachment' => function ($q) {
            $q->whereNotNull('property_document');
        },'sector','block'])->where('id', 370)->get();


        $this->info("Found {$records->count()} properties to process.");
        $logger->info("--- Starting Migration. Found {$records->count()} properties to process. ---");

        foreach ($records as $property) {
           
                $attachement = $property->attachment;
                
                if (!$attachement) {
                    continue;
                }
                
                $oldPath = $attachement->property_document;
                $prefix = $property->sector->name . '/' . $property->block->name. '/';

                if (str_starts_with($oldPath, $prefix)) {
                    $this->line("Skipping already-migrated: {$oldPath}");
                    $logger->info("Already migrated: {$oldPath}");
                    continue;
                }

                $newPath = $prefix . $oldPath;
                $newPath = str_replace('Complete_Property_File', 'Property_Document', $newPath);

                if (!Storage::disk($this->disk)->exists($oldPath)) {
                    $this->error("Missing source file, skipping: {$oldPath}");
                    $logger->error("Missing source file: {$oldPath}");
                    continue;
                }

                $this->info(($dryRun ? '[DRY RUN] ' : '') . "{$oldPath} -> {$newPath}");

                if (!$dryRun) {
                    try {
                        DB::transaction(function () use ($attachement, $oldPath, $newPath) {
                            Storage::disk($this->disk)->move($oldPath, $newPath);
                            $attachement->update(['property_document' => $newPath]);
                        });
                        $logger->info("Moved successfully: {$oldPath} -> {$newPath}");
                    } catch (Exception $e) {
                        $this->error("Failed to move: {$oldPath} -> {$newPath}. Error: {$e->getMessage()}");
                        $logger->error("Failed to move: {$oldPath} -> {$newPath}. Error: {$e->getMessage()}");
                    }
                } else {
                    $logger->info("[DRY RUN] Would move: {$oldPath} -> {$newPath}");
                }


        }

        $this->info('Done.');
        $logger->info("--- Migration Finished ---");
    }
}
