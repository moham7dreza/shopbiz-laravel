<?php

namespace Modules\User\Http\Controllers\Home\Profile;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Address\Entities\Province;
use Modules\Address\Repositories\AddressRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;

class AddressController extends Controller
{
    public AddressRepoEloquentInterface $addressRepo;

    public function __construct(AddressRepoEloquentInterface $addressRepo)
    {
        $this->addressRepo = $addressRepo;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $provinces = $this->addressRepo->provinces()->get();
        $addresses = $this->addressRepo->userAddresses()->get();
        return view('User::home.profile.my-addresses', compact(['provinces', 'addresses']));
    }
}
