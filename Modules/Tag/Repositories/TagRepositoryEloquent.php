<?php

namespace Modules\Tag\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\Tag;

class TagRepositoryEloquent implements TagRepositoryEloquentInterface
{
    /**
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('name', 'like', '%' . $name . '%')
            ->orWhere('type', 'like', '%' . $name . '%')->latest();
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Tag::query();
    }
}
