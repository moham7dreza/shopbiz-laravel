<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Tags extends Component
{
    public Model $model;
    public string $related;
    public string $property;
    public string $name;
    public string $title;
    public string $href;
    public ?string $toolTip;
    public ?string $route;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $related, $name, $property = 'name', $title = 'تگ', $toolTip = null, $href = '#', $route = null)
    {
        $this->model = $model;
        $this->related = $related;
        $this->name = $name;
        $this->property = $property;
        $this->title = $title;
        $this->href = $href;
        $this->toolTip = $toolTip;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.tags');
    }
}
