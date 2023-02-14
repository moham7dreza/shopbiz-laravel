<?php

namespace Modules\Share\Livewire\Panel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class FaPriceInput extends Component
{
    public string $name;
    public string $label;
    public ?string $message;
    public string $col;
    public ?string $method;
    public ?Model $obj;
    public ?string $class;
    public string $type;
    public ?string $price;
    public ?string $discount_ceiling;
    public ?string $minimal_order_amount;
    public ?string $amount;
    public ?string $price_increase;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $label
     * @param $col
     * @param null $message
     * @param string $type
     * @param string $method
     * @param null $obj
     * @param null $class
     * @return void
     */
    public function mount($name, $label, $col, $message = null, string $type = 'text', string $method = 'create',
                          $obj = null, $class = null): void
    {
        $this->name = $name;
        $this->label = $label;
        $this->message = $message;
        $this->col = $col;
        $this->obj = $obj;
        $this->method = $method;
        $this->class = $class;
        $this->type = $type;
        if ($method == 'create') {
            if ($name == 'price') {
                $this->price = old($name);
            } elseif ($name == 'discount_ceiling') {
                $this->discount_ceiling = old($name);
            } elseif ($name == 'minimal_order_amount') {
                $this->minimal_order_amount = old($name);
            } elseif ($name == 'amount') {
                $this->amount = old($name);
            } elseif ($name == 'price_increase') {
                $this->price_increase = old($name);
            }

        } elseif ($method == 'edit') {
            if ($name == 'price') {
                $this->price = old($name, $obj->$name);
            } elseif ($name == 'discount_ceiling') {
                $this->discount_ceiling = old($name, $obj->$name);
            } elseif ($name == 'minimal_order_amount') {
                $this->minimal_order_amount = old($name, $obj->$name);
            } elseif ($name == 'amount') {
                $this->amount = old($name, $obj->$name);
            } elseif ($name == 'price_increase') {
                $this->price_increase = old($name, $obj->$name);
            }
        }

    }

//    public function UpdatingPrice($value)
//    {
//        $this->price = $value;
//    }
    /**
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::livewire.panel.fa-price-input');
    }
}
