<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class File extends Component
{
    public string $name;
    public string $label;
    public ?string $message;
    public string $col;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $col, $message)
    {
        $this->name = $name;
        $this->label = $label;
        $this->message = $message;
        $this->col = $col;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.file');
    }
}
