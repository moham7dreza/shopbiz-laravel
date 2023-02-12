<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteForm extends Component
{
    public ?string $title;
    public string $route;
    public string $color;
    public ?string $text;
    public string $icon;
    public ?string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($route, $color = 'outline-danger', $icon = 'trash-alt', $title = null, $text = null, $class = null,)
    {
        $this->title = $title;
        $this->route = $route;
        $this->text = $text;
        $this->icon = $icon;
        $this->class = $class;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.delete-form');
    }
}
