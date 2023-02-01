<?php

namespace Modules\Post\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Post\Entities\Post;

class PostRepoEloquent implements PostRepoEloquentInterface
{

    /**
     * Find article by slug.
     *
     * @param  $slug
     * @return mixed
     */
    public function findPostBySlug($slug): mixed
    {
        return $this->query()->where('slug', $slug)->active()->firstOrFail();
    }

    /**
     * Get random articles.
     *
     * @param  string|int|null $id
     * @return mixed
     */
    public function getRandomPosts(string|int $id = null): mixed
    {
        $query = $this->query()->active()->inRandomOrder()->limit(4);

        if (! is_null($id)) {
            return $query->where('id', '!=', $id);
        }

        return $query->get();
    }

    /**
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('title' , 'like', '%' . $name . '%')
            ->orWhere('summary' , 'like', '%' . $name . '%')
            ->orWhere('body' , 'like', '%' . $name . '%')->latest();
    }
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
     * @param $post
     * @return mixed
     */
    public function relatedItems($post): mixed
    {
        return $post->category->posts()->where('id', '!=', $post->id)->latest();
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
     * @return mixed
     */
    public function orderByViews(): mixed
    {
        return $this->query()->active()->orderByUniqueViews();
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
     * @return int
     */
    public function postsCount(): int
    {
        return $this->query()->count();
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
