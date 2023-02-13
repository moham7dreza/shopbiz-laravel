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
    public ?string $old;
    public string $label;
    public ?string $message;
    public string $col;
    public ?string $method;
    public ?Model $obj;
    public ?string $class;
    public string $type;
    public string $price;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($name, $label, $col, $message = null, $type = 'text', $method = 'create',
                                $obj = null, $class = null, $old = null): void
    {
        $this->name = $name;
        $this->label = $label;
        $this->message = $message;
        $this->col = $col;
        $this->obj = $obj;
        $this->method = $method;
        $this->class = $class;
        $this->type = $type;
        $this->old = $old;
        if ($method == 'edit') {
            $this->price = $obj->price;
        }
    }
    /**
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Share::livewire.panel.fa-price-input');
    }
}
