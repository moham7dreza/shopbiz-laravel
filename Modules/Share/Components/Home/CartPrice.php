<?php

namespace Modules\Share\Components\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class CartPrice extends Component
{
    public ?Collection $cartItems;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * @return Application|Factory|Htmlable|View
     */
    public function render(): View|Factory|Htmlable|Application
    {
        return view('Share::components.home.cart-price');
    }
}
