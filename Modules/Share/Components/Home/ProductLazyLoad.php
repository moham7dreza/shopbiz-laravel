<?php

namespace Modules\Share\Components\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ProductLazyLoad extends Component
{
    public string $class;
    public string $title;
    public Collection $products;
    public array $productIds;
    public string $viewAllRoute;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $products, $productIds, $viewAllRoute, $class = '')
    {
        $this->title = $title;
        $this->products = $products;
        $this->productIds = $productIds;
        $this->viewAllRoute = $viewAllRoute;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::components.home.product-lazy-load');
    }
}
