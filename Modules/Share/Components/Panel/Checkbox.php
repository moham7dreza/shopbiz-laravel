<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Checkbox extends Component
{
    public string $name;
    public string $method;
    public string $route;
    public string $property;
    public ?string $class;
    public Model $model;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $method, $route, $property, $model, $class = '')
    {
        $this->name = $name;
        $this->method = $method;
        $this->route = $route;
        $this->property = $property;
        $this->model = $model;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.checkbox');
    }
}
