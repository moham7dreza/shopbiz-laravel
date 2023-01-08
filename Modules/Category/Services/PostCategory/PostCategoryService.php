<?php

namespace Modules\Category\Services\PostCategory;


use Illuminate\Database\Eloquent\Builder;
use Modules\Category\Entities\PostCategory;
use Modules\Category\Entities\ProductCategory;

class PostCategoryService implements PostCategoryServiceInterface
{
    /**
     * Store category.
     *
     * @param  $request
     * @return Builder|\Illuminate\Database\Eloquent\Model
     */
    public function store($request)
    {
        return $this->query()->create([
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'title' => $request->title,
            'slug' => ShareService::makeSlug($request->title),
            'keywords' => $request->keywords,
            'status' => $request->status,
            'description' => $request->description,
        ]);
    }

    /**
     * Update category by id.
     *
     * @param  $request
     * @param  $id
     * @return int
     */
    public function update($request, $id)
    {
        return $this->query()->where('id', $id)->update([
            'parent_id' => $request->parent_id,
            'title' => $request->title,
            'slug' => ShareService::makeSlug($request->title),
            'keywords' => $request->keywords,
            'status' => $request->status,
            'description' => $request->description,
        ]);
    }

    /**
     * Return category query.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return PostCategory::query();
    }
}
