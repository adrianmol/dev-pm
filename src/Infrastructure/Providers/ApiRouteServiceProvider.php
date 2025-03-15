<?php

namespace DevPM\Infrastructure\Providers;

use DevPM\Infrastructure\Helpers\DevPMHelper;
use Illuminate\Support\ServiceProvider;

class ApiRouteServiceProvider extends ServiceProvider
{
    public const string API_ROUTE_FOLDER_NAME = '/Route/Api';

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->getAllApiRouteFiles();
    }

    protected function getAllApiRouteFiles(): void
    {
        if (is_dir(DevPMHelper::getApplicationPath())) {
            $applicationFolders = array_diff(scandir(DevPMHelper::getApplicationPath()) ?: [], ['.', '..']);
            foreach ($applicationFolders as $moduleFolder) {
                if (is_dir(DevPMHelper::getApplicationPath().'/'.$moduleFolder.static::API_ROUTE_FOLDER_NAME)) {
                    $moduleMigrationFiles = array_diff(
                        scandir(
                            DevPMHelper::getApplicationPath().'/'.$moduleFolder.static::API_ROUTE_FOLDER_NAME) ?: [],
                        ['.', '..'],
                    );
                    foreach ($moduleMigrationFiles as $file) {
                        $this->loadRoutesFrom(DevPMHelper::getApplicationPath().'/'.$moduleFolder.static::API_ROUTE_FOLDER_NAME.'/'.$file);
                    }
                }
            }
        }
    }
}
