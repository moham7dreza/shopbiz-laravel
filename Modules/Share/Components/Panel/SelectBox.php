<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
    public array $arr;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $col, $message, $arr, $method = 'create', $model = null, $class = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->message = $message;
        $this->col = $col;
        $this->model = $model;
        $this->method = $method;
        $this->class = $class;
        $this->arr = $arr;
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
