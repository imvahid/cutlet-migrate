<?php

namespace Va\CutletMigrate\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:update {--m|migrate} {--s|seed} {--status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all mysql migrations that if not in migrations default directory and re-run all of them';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            /*
             * If any tables not migrated last time,
             * it's migrate and continue to update mysql
             * functions, procedures, triggers and views migrations
             */
            if ($this->option('migrate')) {
                $this->call('migrate');
            }

            /*
             * If you use this option, re-run the seeders
             */
            if ($this->option('seed')) {
                $this->call('db:seed');
            }

            /*
             * Find all of functions, procedures, triggers and views migrations in directories
             */
            $migrations_to_rerun = array_merge(
                $functions = array_diff( scandir( database_path() . '/migrations/' . config('cutlet-migrate.functions_path') ), [ '.', '..' ] ),
                $procedures = array_diff( scandir( database_path() . '/migrations/' . config('cutlet-migrate.procedures_path') ), [ '.', '..' ] ),
                $triggers = array_diff( scandir( database_path() . '/migrations/' . config('cutlet-migrate.triggers_path') ), [ '.', '..' ] ),
                $views = array_diff( scandir( database_path() . '/migrations/' . config('cutlet-migrate.views_path') ), [ '.', '..' ] )
            );

            foreach( $migrations_to_rerun as $index => $name ){
                $migrations_to_rerun[ $index ] = "'" . basename( $name, '.php' ) . "'";
            }

            $migrations_to_rerun = implode( ",", $migrations_to_rerun );

            /*
             * Delete functions, procedures, triggers and views migrations
             * from migrations table and migrate again this migrations ...
             */
            DB::table('migrations')->whereIn('migration', $migrations_to_rerun)->delete();

            $this->call('migrate');

            /*
             * If you use this option, show the migrations table status for you after migrated all migrations
             */
            if ($this->option('status')) {
                $this->call('migrate:status');
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
