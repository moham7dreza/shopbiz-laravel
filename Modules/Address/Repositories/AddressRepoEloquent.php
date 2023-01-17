<?php

namespace Modules\Address\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
     * Find delivery method by id.
     *
     * @param  $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id): Model|Collection|Builder|array|null
    {
        return $this->query()->findOrFail($id);
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
