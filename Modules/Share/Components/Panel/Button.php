<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public string $title;
    public ?string $class;
    public string $type;
    public string $col;
    public string $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($col, $class = null, $title = 'Submit', $type = 'submit', $color = 'outline-primary')
    {
        $this->title = $title;
        $this->class = $class;
        $this->type = $type;
        $this->col = $col;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.button');
    }
}
