<?php

namespace Modules\Share\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Share\Components\Home\CartPrice;
use Modules\Share\Components\Home\ProductLazyLoad;
use Modules\Share\Components\Home\ProductLazyLoadWithReactions;
use Modules\Share\Components\Panel\ATag;
use Modules\Share\Components\Panel\Button;
use Modules\Share\Components\Panel\Card;
use Modules\Share\Components\Panel\Checkbox;
use Modules\Share\Components\Panel\DeleteForm;
use Modules\Share\Components\Panel\Dropdown;
use Modules\Share\Components\Panel\ImageIndex;
use Modules\Share\Components\Panel\Input;
use Modules\Share\Components\Panel\MultiSelection;
use Modules\Share\Components\Panel\SearchForm;
use Modules\Share\Components\Panel\Section;
use Modules\Share\Components\Panel\SelectBox;
use Modules\Share\Components\Panel\SortBtn;
use Modules\Share\Components\Panel\TableRow;
use Modules\Share\Components\Panel\Tags;
use Modules\Share\Components\Panel\TextArea;
use Modules\Share\Components\Share\Error;
use Modules\Share\Livewire\Panel\FaPriceInput;

class ShareServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for panel controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Share\Http\Controllers';

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
     * Get middleware route.
     *
     * @var array|string[]
     */
    public array $middlewareRoute = ['web'];

    /**
     * Get route path.
     *
     * @var string
     */
    public string $routePath = '/../Routes/share_routes.php';

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
        $this->loadHomeComponents();
        $this->loadLivewireComponents();
        $this->loadRouteFiles();
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
     * Load panel route files.
     *
     * @return void
     */
    private function loadRouteFiles(): void
    {
        Route::middleware($this->middlewareRoute)
            ->namespace($this->namespace)
            ->group(__DIR__ . $this->routePath);
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
            Card::class,
            ImageIndex::class,
            Dropdown::class,
            Tags::class,
            SortBtn::class
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

    /**
     * Load components about panel.
     *
     * @return void
     */
    private function loadHomeComponents(): void
    {
        $this->loadViewComponentsAs('home', [
            CartPrice::class,
            ProductLazyLoad::class,
            ProductLazyLoadWithReactions::class,
        ]);
    }

    /**
     * @return void
     */
    private function loadLivewireComponents(): void
    {
        Livewire::component('fa-price-input', FaPriceInput::class);
    }
}
