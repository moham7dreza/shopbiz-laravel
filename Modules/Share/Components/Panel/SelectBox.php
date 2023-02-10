<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class SelectBox extends Component
{
    public string $name;
    public string $label;
    public ?string $message;
    public string $col;
    public ?string $method;
    public ?Model $model;
    public ?string $class;
    public ?array $arr;
    public ?Collection $collection;
    public ?string $property;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $col, $message, $arr = null, $collection = null, $property = null, $method = 'create', $model = null, $class = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->message = $message;
        $this->col = $col;
        $this->model = $model;
        $this->method = $method;
        $this->class = $class;
        $this->arr = $arr;
        $this->collection = $collection;
        $this->property = $property;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.select-box');
    }
}
