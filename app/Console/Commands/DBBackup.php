<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Process;

class DBBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:d-b-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database backup command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // create backups folder
        Storage::makeDirectory('backups');

        // backup file path
        $path = Storage::path(
            'backups/backup-' . now()->format('Y-m-d-H-i-s') . '.sql'
        );

        // mysqldump command
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s --port=%s %s > "%s"',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_HOST'),
            env('DB_PORT'),
            env('DB_DATABASE'),
            $path
        );

        // run command
        $process = Process::run($command);

        if ($process->successful()) {
            $this->info("Database backup created successfully at: $path");
        } else {
            $this->error("Failed to create database backup");
            $this->error($process->errorOutput());
        }
    }
}