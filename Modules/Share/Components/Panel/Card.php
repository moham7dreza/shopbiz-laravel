<?php

namespace Modules\Share\Components\Panel;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public string $lgCol;
    public string $mdCol;
    public string $class;
    public string $counter;
    public string $title;
    public string $icon;
    public ?string $updatedAt;
    public string $route;
    public string $group;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $counter, $icon, $route, $updatedAt = null, $lgCol = '3', $mdCol = '6', $class = null, $group = 'fas')
    {
        $this->lgCol = $lgCol;
        $this->mdCol = $mdCol;
        $this->icon = $icon;
        $this->class = $class;
        $this->title = $title;
        $this->counter = $counter;
        $this->updatedAt = $updatedAt ?? Carbon::now();
        $this->route = $route;
        $this->group = $group;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.card');
    }
}
