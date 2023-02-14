<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Input extends Component
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
    public string $type;
    public bool $date;
    public bool $showImage;
    public bool $select2;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $col, $message = null, $type = 'text', $method = 'create', $dadClass = 'mt-1',
                                $model = null, $class = null, $old = null, $date = false, $showImage = false, $select2 = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->message = $message;
        $this->col = $col;
        $this->model = $model;
        $this->method = $method;
        $this->class = $class;
        $this->dadClass = $dadClass;
        $this->type = $type;
        $this->old = $old;
        $this->date = $date;
        $this->showImage = $showImage;
        $this->select2 = $select2;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.input');
    }
}
