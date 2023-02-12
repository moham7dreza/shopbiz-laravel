<?php

namespace Modules\Share\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;
use Modules\Share\Components\Panel\ATag;
use Modules\Share\Components\Panel\Button;
use Modules\Share\Components\Panel\Checkbox;
use Modules\Share\Components\Panel\DeleteForm;
use Modules\Share\Components\Panel\File;
use Modules\Share\Components\Panel\Input;
use Modules\Share\Components\Panel\MultiSelection;
use Modules\Share\Components\Panel\SearchForm;
use Modules\Share\Components\Panel\Section;
use Modules\Share\Components\Panel\SelectBox;
use Modules\Share\Components\Panel\Status;
use Modules\Share\Components\Panel\TableRow;
use Modules\Share\Components\Panel\TextArea;
use Modules\Share\Components\Share\Error;

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
    public function register(): void
    {
        $this->loadMigrationFiles();
        $this->loadViewFiles();
        $this->loadMigrationFiles();
        $this->loadFactoriesFiles();
        $this->loadConfigFiles();
        $this->loadPanelComponents();
        $this->loadShareComponents();
    }

    /**
     * Load factories.
     *
     * @return void
     */
    private function loadFactoriesFiles(): void
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
    private function loadMigrationFiles(): void
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
    private function loadConfigFiles(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'shareConfig');
    }

    /**
     * Load components about panel.
     *
     * @return void
     */
    private function loadPanelComponents(): void
    {
        $this->loadViewComponentsAs('panel', [
            Input::class,
            File::class,
            SelectBox::class,
            TextArea::class,
            Button::class,
            Section::class,
            MultiSelection::class,
            ATag::class,
            DeleteForm::class,
            Checkbox::class,
            SearchForm::class,
            TableRow::class,
        ]);
    }

    /**
     * Load components about panel.
     *
     * @return void
     */
    private function loadShareComponents(): void
    {
        $this->loadViewComponentsAs('share', [
            Error::class,
        ]);
    }
}
