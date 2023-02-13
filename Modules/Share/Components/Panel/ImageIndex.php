<?php

namespace Modules\Share\Components\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class ImageIndex extends Component
{
    public Model $model;
    public string $property;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model, $property = 'image')
    {
        $this->model = $model;
        $this->property = $property;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.panel.image-index');
    }
}
