<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Section extends Component
{
    public string $id;
    public string $label;
    public string $col;
    public string $text;
    public ?string $class;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $label, $col, $text, $class = null)
    {
        $this->id = $id;
        $this->label = $label;
        $this->text = $text;
        $this->col = $col;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.section');
    }
}
