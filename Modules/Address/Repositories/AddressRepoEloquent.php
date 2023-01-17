<?php

namespace Modules\Address\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\Address\Entities\Address;
use Modules\Address\Entities\City;
use Modules\Address\Entities\Country;
use Modules\Address\Entities\Province;

class AddressRepoEloquent implements AddressRepoEloquentInterface
{
    /**
     * @return mixed
     */
    public function userAddresses(): mixed
    {
        return auth()->user()->addresses()->latest();
    }

    /**
     * @return Builder
     */
    public function provinces(): Builder
    {
        return Province::query()->latest();
    }

    /**
     * @return Builder
     */
    public function cities(): Builder
    {
        return City::query()->latest();
    }


    /**
     * @return Builder
     */
    public function countries(): Builder
    {
        return Country::query()->latest();
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Address::query();
    }
}
