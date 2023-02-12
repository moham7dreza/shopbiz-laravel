<?php

namespace Modules\Share\Components\Panel;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableRow extends Component
{
    public ?string $class;
    public ?string $dataClass;
    public string $td;
    public string $th;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($th, $td, $class = null, $dataClass = null)
    {
        $this->th = $th;
        $this->td = $td;
        $this->class = $class;
        $this->dataClass = $dataClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.table-row');
    }
}
