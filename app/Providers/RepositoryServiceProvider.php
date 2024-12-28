<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->getFiles() as $key => $file) {
            $className = $file->getFilenameWithoutExtension();

            if (str_starts_with($className, 'Contract')) {
                continue;
            }

            $interface = $this->getContractNamespace().$className;

            $implementation = $this->getImplementation().$className;

            if (interface_exists($interface) && class_exists($implementation)) {
                $this->app->singleton($interface, $implementation);
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected function getRepositoryPath(): string
    {
        return app_path('Repositories');
    }

    protected function getContractNamespace(): string
    {
        return 'App\\Contracts\\Repositories\\';
    }

    protected function getImplementation(): string
    {
        return 'App\\Repositories\\';
    }

    protected function getFiles()
    {
        return File::allFiles($this->getRepositoryPath());
    }
}
