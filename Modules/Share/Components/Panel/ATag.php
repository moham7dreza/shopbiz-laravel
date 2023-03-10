<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ATag extends Component
{
    public ?string $title;
    public string $route;
    public string $color;
    public ?string $text;
    public ?string $icon;
    public string $group;
    public ?string $class;
    public bool $panel;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($route, $color = 'primary', $icon = null, $title = null, $text = null, $class = null, $group = 'fa', $panel = true)
    {
        $this->title = $title;
        $this->route = $route;
        $this->text = $text;
        $this->icon = $icon;
        $this->class = $class;
        $this->color = $color;
        $this->group = $group;
        $this->panel = $panel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.a-tag');
    }
}
