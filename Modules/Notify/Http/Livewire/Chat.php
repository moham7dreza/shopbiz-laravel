<?php

namespace Modules\Notify\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Chat extends Component
{
    public function mount()
    {

    }

    /**
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('Notify::livewire.chat');
    }
}
