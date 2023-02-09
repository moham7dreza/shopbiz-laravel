<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class MultiSelection extends Component
{
    public string $name;
    public string $label;
    public ?string $message;
    public string $col;
    public ?string $class;
    public Collection $items;
    public Model $related;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $col, $message, $items, $related, $class = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->message = $message;
        $this->col = $col;
        $this->class = $class;
        $this->items = $items;
        $this->related = $related;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.multi-selection');
    }
}
