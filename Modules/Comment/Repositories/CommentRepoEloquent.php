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
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('body', 'like', '%' . $name . '%')->latest();
    }

    /**
     * @return Builder
     */
    public function unseenComments(): Builder
    {
        return $this->query()->where('seen', Comment::UNSEEN)->latest();
    }

    /**
     * @return Builder
     */
    public function getLatestPostComments(): Builder
    {
        return $this->query()->where([
            ['commentable_type', 'Modules\Post\Entities\Post']
        ])->latest();
    }

    /**
     * @return Builder
     */
    public function getLatestProductComments(): Builder
    {
        return $this->query()->where([
            ['commentable_type', 'Modules\Product\Entities\Product']
        ])->latest();
    }

    /**
     * @return Collection|Builder[]
     */
    public function getUnseenPostComments(): array|Collection
    {
        return $this->query()->where([
            ['seen', 0],
            ['commentable_type', 'Modules\Post\Entities\Post']
        ])->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function getUnseenProductComments(): array|Collection
    {
        return $this->query()->where([
            ['seen', 0],
            ['commentable_type', 'Modules\Product\Entities\Product']
        ])->get();
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
        return $this->query()->where([
            ['status', $this->class::STATUS_ACTIVE],
            ['commentable_type', 'Modules\Post\Entities\Post']
        ])->latest();
    }

    public function findActiveProductComments(): Builder
    {
        return $this->query()->where([
            ['status', $this->class::STATUS_ACTIVE],
            ['commentable_type', 'Modules\Product\Entities\Product']
        ])->latest();
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
     * @return int
     */
    public function commentsCount(): int
    {
        return $this->query()->count();
    }

    /**
     * @return Builder
     */
    public function latestCommentWithoutAdmin(): Builder
    {
        return $this->query()->where('author_id', '!=', auth()->id())->latest();
    }


    // home

    /**
     * @return Builder
     */
    public function latestActiveParentComments(): Builder
    {
        return $this->query()->where([
            ['status', $this->class::STATUS_ACTIVE],
            ['parent_id', null]
        ])->latest();
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
