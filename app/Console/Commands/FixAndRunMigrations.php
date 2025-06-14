<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixAndRunMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fix-and-run-migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Temporarily swaps CI/Laravel migration tables and ensures the sessions table exists.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration table swap and session table check...');

        if (!Schema::hasTable('migrations') || !Schema::hasTable('migrations_legacy')) {
            $this->error('Required tables ("migrations" and/or "migrations_legacy") not found. Cannot proceed.');
            return 1;
        }

        // Swap tables: CI -> temp, Laravel -> main
        Schema::rename('migrations', 'migrations_ci_temp');
        $this->info('Renamed "migrations" (CI) to "migrations_ci_temp".');
        Schema::rename('migrations_legacy', 'migrations');
        $this->info('Renamed "migrations_legacy" (Laravel) to "migrations".');

        try {
            $this->info('Checking for sessions table...');
            if (!Schema::hasTable('sessions')) {
                $this->info('Sessions table not found. Creating it now...');
                DB::statement("
                    CREATE TABLE `sessions` (
                        `id` varchar(255) NOT NULL,
                        `user_id` bigint unsigned NULL,
                        `ip_address` varchar(45) NULL,
                        `user_agent` text NULL,
                        `payload` longtext NOT NULL,
                        `last_activity` int NOT NULL,
                        PRIMARY KEY (`id`),
                        INDEX `sessions_user_id_index` (`user_id`),
                        INDEX `sessions_last_activity_index` (`last_activity`)
                    ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
                ");
                $this->info('Successfully created `sessions` table.');
            } else {
                $this->info('Sessions table already exists. No action needed.');
            }
        } catch (\Exception $e) {
            $this->error('An error occurred while creating the sessions table: ' . $e->getMessage());
        } finally {
            // Swap tables back regardless of success or failure
            $this->info('Swapping migration tables back...');
            Schema::rename('migrations', 'migrations_legacy');
            $this->info('Renamed "migrations" (Laravel) back to "migrations_legacy".');
            Schema::rename('migrations_ci_temp', 'migrations');
            $this->info('Renamed "migrations_ci_temp" back to "migrations" (CI).');
            $this->info('Process complete.');
        }

        return 0;
    }
}
