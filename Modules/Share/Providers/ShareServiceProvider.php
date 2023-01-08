<?php

namespace Modules\Share\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class ShareServiceProvider extends ServiceProvider
{
    /**
     * Get migration path.
     *
     * @var string
     */
    private string $migrationPath = '/../Database/Migrations/';

    /**
     * Get view path.
     *
     * @var string
     */
    private string $viewPath = '/../Resources/Views/';

    /**
     * Get name.
     *
     * @var string
     */
    private string $name = 'Share';

    /**
     * @return void
     */
    public function register()
    {
        $this->loadViewFiles();
        $this->loadMigrationFiles();
        $this->loadFactoriesFiles();
        $this->loadConfigFiles();
    }

    /**
     * Load factories.
     *
     * @return void
     */
    private function loadFactoriesFiles()
    {
        Factory::guessFactoryNamesUsing(static function (string $modelName) {
            return 'Modules\Share\Database\\Factories\\' . class_basename($modelName) . 'Factory';
        });
    }

    /**
     * Load migrations.
     *
     * @return void
     */
    private function loadMigrationFiles()
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load share view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load share config files.
     *
     * @return void
     */
    private function loadConfigFiles()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'shareConfig');
    }
}
