<?php

namespace Modules\Contact\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\Contact\Entities\Contact;

class ContactRepoEloquent implements ContactRepoEloquentInterface
{
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
