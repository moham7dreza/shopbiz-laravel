<?php

namespace Modules\Contact\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Entities\Contact;

class ContactRepoEloquent implements ContactRepoEloquentInterface
{

    /**
     * @param $property
     * @param $dir
     * @param string $model
     * @return Builder
     */
    public function sort($property, $dir, string $model = 'contact'): Builder
    {
        if ($model == 'appointment') {
            return $this->query()->appointment()->orderBy($property, $dir);
        }
        return $this->query()->contact()->orderBy($property, $dir);
    }

    /**
     * @param $name
     * @param string $model
     * @return Model|Builder|null
     */
    public function search($name, string $model = 'contact'): Model|Builder|null
    {
        if ($model == 'appointment') {
            return $this->query()->appointment()->where('email', 'like', '%' . $name . '%')->latest();
        }
        return $this->query()->contact()->where('email', 'like', '%' . $name . '%')->latest();
    }

    /**
     * @return mixed
     */
    public function getUnReadContacts(): mixed
    {
        return $this->query()->read(Contact::NOT_READ)->contact()->get();
    }

    /**
     * @return mixed
     */
    public function getUnReadAppointments(): mixed
    {
        return $this->query()->read(Contact::NOT_READ)->appointment()->get();
    }

    /**
     * @return mixed
     */
    public function getLatestContacts(): mixed
    {
        return $this->query()->contact()->latest();
    }

    /**
     * @return mixed
     */
    public function getLatestAppointments(): mixed
    {
        return $this->query()->appointment()->latest();
    }

    /**
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * @return Builder
     */
    private function query(): Builder
    {
        return Contact::query();
    }
}
