<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchForm extends Component
{
    public string $route;
    public string $name;
    public ?string $class;
    public string $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($route, $name = 'search', $placeholder = 'جست و جو', $class = '')
    {
        $this->route = $route;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.search-form');
    }
}
