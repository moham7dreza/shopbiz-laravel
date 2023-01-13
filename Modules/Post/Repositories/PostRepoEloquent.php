<?php

namespace Modules\Post\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Modules\Post\Entities\Post;

class PostRepoEloquent implements PostRepoEloquentInterface
{
    /**
     * Get latest articles.
     *
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * Find article by id.
     *
     * @param  $id
     * @return Builder
     */
    public function findById($id)
    {
        return $this->query()->findOrFail($id);
    }

    public function findBySlug($slug)
    {
        return $this->query()->where('slug', $slug)->first();
    }

    // home queries
    public function relatedPosts($category_id, $id): Builder
    {
        return $this->query()->where([
            ['status', Post::STATUS_ACTIVE],
            ['category_id', $category_id],
            ['id', '!=', $id]
        ]);
    }

    public function getPostsByViews(): Builder
    {
        return $this->query()->where('status', Post::STATUS_ACTIVE)->orderByViews();
    }

    public function getPostsByUserId($id): Builder
    {
        return $this->query()->where([['status', Post::STATUS_ACTIVE], ['author_id', $id]]);
    }

    public function getPostsByCategoryId($id): Builder
    {
        return $this->query()->where([['status', Post::STATUS_ACTIVE], ['category_id', $id]]);
    }

    public function home(): Builder
    {
        return $this->query()->where('status', Post::STATUS_ACTIVE)->latest();
    }


    /**
     * Delete article by id.
     *
     * @param  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * Get builder query.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Post::query();
    }
}
