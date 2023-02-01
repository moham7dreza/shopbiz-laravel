<?php

namespace Modules\Tag\Services;

use Illuminate\Database\Eloquent\Builder;
use Modules\Tag\Entities\Tag;

class TagService
{
    public function store($request)
    {
        return $this->query()->create([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
        ]);
    }

    public function update($request, $tag)
    {
        return $tag->update([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
        ]);
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Tag::query();
    }
}
