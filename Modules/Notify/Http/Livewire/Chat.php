<?php

namespace Modules\Notify\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\User\Repositories\UserRepoEloquentInterface;

class Chat extends Component
{
    public string $message = '';
    public array $messages = [];

    protected array $rules = [
        'message' => 'required|string|min:3|max:1000',
//        'comment_text' => 'required | regex:/^[ا-یa-zA-Z0-9 ? : - . ، * ! ]+$/u'
    ];

    public function mount()
    {

    }

    public function sendMsg()
    {
        $this->validate();
        $this->messages[] = $this->message;
    }

    /**
     * @param UserRepoEloquentInterface $userRepoEloquent
     * @return Application|Factory|View
     */
    public function render(UserRepoEloquentInterface $userRepoEloquent): View|Factory|Application
    {
        $admin = $userRepoEloquent->findSystemAdmin();
        return view('Notify::livewire.chat', ['admin' => $admin, 'messages' => $this->messages]);
    }
}
