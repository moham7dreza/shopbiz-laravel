<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    public string $color;
    public string $group;
    public string $icon;
    public string $text;
    public ?string $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text, $icon, $group = 'fa', $color = 'outline-info', $class = null)
    {
        $this->text = $text;
        $this->icon = $icon;
        $this->group = $group;
        $this->color = $color;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.dropdown');
    }
}
