<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class TextArea extends Component
{
    public string $name;
    public ?string $old;
    public string $label;
    public ?string $message;
    public string $col;
    public ?string $method;
    public ?Model $model;
    public ?string $class;
    public ?string $dadClass;
    public ?string $rows;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $col, $message, $rows = '6',  $method = 'create', $model = null, $class = null, $old = null, $dadClass = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->message = $message;
        $this->col = $col;
        $this->model = $model;
        $this->method = $method;
        $this->class = $class;
        $this->rows = $rows;
        $this->old = $old;
        $this->dadClass = $dadClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.text-area');
    }
}
