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
    public function getLatestArticles()
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
