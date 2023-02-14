<?php

namespace Modules\Share\Components\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class CartPrice extends Component
{
    public Collection $cartItems;
    public ?Model $commonDiscount;
    public ?int $finalAmount;
    public string $formId;
    public string $buttonText;
    public ?Model $copanDiscount;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($cartItems, $formId, $finalAmount = null, $buttonText = 'تکمیل فرآیند خرید', $commonDiscount = null, $copanDiscount = null)
    {
        $this->cartItems = $cartItems;
        $this->formId = $formId;
        $this->finalAmount = $finalAmount;
        $this->buttonText = $buttonText;
        $this->commonDiscount = $commonDiscount;
        $this->copanDiscount = $copanDiscount;
    }


    /**
     * @return Application|Factory|Htmlable|View
     */
    public function render(): View|Factory|Htmlable|Application
    {
        return view('Share::components.home.cart-price');
    }
}
