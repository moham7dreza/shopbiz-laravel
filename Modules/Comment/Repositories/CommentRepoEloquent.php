<?php

namespace Modules\Comment\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Comment\Entities\Comment;

class CommentRepoEloquent implements CommentRepoEloquentInterface
{
    private string $class = Comment::class;

    /**
     * @param $property
     * @param $dir
     * @param string $model
     * @return Builder
     */
    public function sort($property, $dir, string $model = 'product'): Builder
    {
        if ($model == 'post') {
            return $this->query()->postType()->orderBy($property, $dir);
        }
        return $this->query()->productType()->orderBy($property, $dir);
    }

    /**
     * @param $name
     * @param string $model
     * @return Model|Builder|null
     */
    public function search($name, string $model = 'product'): Model|Builder|null
    {
        if ($model == 'post') {
            return $this->query()->postType()->where('body', 'like', '%' . $name . '%')->latest();
        }
        return $this->query()->productType()->where('body', 'like', '%' . $name . '%')->latest();
    }

    /**
     * @return Builder
     */
    public function unseenComments(): Builder
    {
        return $this->query()->seen(Comment::UNSEEN)->latest();
    }

    /**
     * panel
     * @return Builder
     */
    public function getLatestPostComments(): Builder
    {
        return $this->query()->postType()->latest();
    }

    /**
     * panel
     * @return Builder
     */
    public function getLatestProductComments(): Builder
    {
        return $this->query()->productType()->latest();
    }

    /**
     * panel
     * @return Collection|Builder[]
     */
    public function getUnseenPostComments(): array|Collection
    {
        return $this->query()->seen(Comment::UNSEEN)->postType()->get();
    }

    /**
     * panel
     * @return Builder[]|Collection
     */
    public function getUnseenProductComments(): array|Collection
    {
        return $this->query()->seen(Comment::UNSEEN)->productType()->get();
    }

    /**
     * Get latest comments.
     *
     * @return Builder
     */
    public function getLatest(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * Find comment by id.
     *
     * @param  $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id)
    {
        return $this->query()->findOrFail($id);
    }

    public function findActivePostComments(): Builder
    {
        return $this->query()->post()->latest();
    }

    public function findActiveProductComments(): Builder
    {
        return $this->query()->product()->latest();
    }

    /**
     * Get active comment by id.
     *
     * @param  $id
     * @return Builder|Model|null
     */
    public function findActiveCommentById($id): Model|Builder|null
    {
        return $this->query()
            ->where('id', $id)
            ->where('status', Comment::STATUS_ACTIVE)
            ->first();
    }

    /**
     * panel
     * @return int
     */
    public function commentsCount(): int
    {
        return $this->query()->count();
    }

    /**
     * panel
     * @return int
     */
    public function latestProductCommentsWithoutAdminCount(): int
    {
        return $this->query()->productType()->where('author_id', '!=', auth()->id())->count();
    }

    /**
     * panel
     * @return Builder
     */
    public function latestCommentWithoutAdmin(): Builder
    {
        return $this->query()->where('author_id', '!=', auth()->id())->latest();
    }

    /**
     * panel
     * @return Builder
     */
    public function latestUnseenCommentWithoutAdmin(): Builder
    {
        return $this->query()->seen(Comment::UNSEEN)->where('author_id', '!=', auth()->id())->latest();
    }


    // home

    /**
     * @return Builder
     */
    public function latestActiveParentComments(): Builder
    {
        return $this->query()->all()->latest();
    }
    /**
     * Get query model(builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Comment::query();
    }
}
