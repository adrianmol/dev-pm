<?php

namespace DevPM\Infrastructure\Providers;

use DevPM\Infrastructure\Helpers\DevPMHelper;
use Illuminate\Support\ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{
    public const string MIGRATION_FOLDER_NAME = '/Persistence/Migration';

    public static array $files = [];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom($this->getAllMigrationFiles());
        }
    }

    protected function getAllMigrationFiles(): array
    {
        if (is_dir(DevPMHelper::getApplicationPath())) {
            $applicationFolders = array_diff(scandir(DevPMHelper::getApplicationPath()) ?: [], ['.', '..']);
            foreach ($applicationFolders as $moduleFolder) {
                if (is_dir(DevPMHelper::getApplicationPath().'/'.$moduleFolder.static::MIGRATION_FOLDER_NAME)) {
                    $moduleMigrationFiles = array_diff(
                        scandir(
                            DevPMHelper::getApplicationPath().'/'.$moduleFolder.static::MIGRATION_FOLDER_NAME) ?: [],
                        ['.', '..'],
                    );
                    foreach ($moduleMigrationFiles as $file) {
                        static::$files[] = DevPMHelper::getApplicationPath().'/'.$moduleFolder.static::MIGRATION_FOLDER_NAME.'/'.$file;
                    }
                }
            }
        }

        return static::$files;
    }
}
