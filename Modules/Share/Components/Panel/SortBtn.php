<?php

namespace Modules\Share\Components\Panel;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SortBtn extends Component
{
    public ?string $class;
    public string $route;
    public string $title;
    public string $property;
    public ?string $params;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($route, $title, $class = null, $property = 'name', $params = null)
    {
        $this->route = $route;
        $this->title = $title;
        $this->class = $class;
        $this->property = $property;
        $this->params = $params;
    }


    /**
     * @return Closure|Application|Htmlable|Factory|View|string
     */
    public function render(): View|Factory|Htmlable|string|Closure|Application
    {
        return view('Share::components.panel.sort-btn');
    }
}
