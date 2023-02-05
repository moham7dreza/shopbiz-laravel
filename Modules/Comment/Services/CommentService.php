<?php

namespace Modules\Comment\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Comment\Entities\Comment;
use Modules\Share\Services\ShareService;

class CommentService
{
    /**
     * @param $request
     * @param $model
     * @return Builder|Model
     */
    public function store($request, $model): Model|Builder
    {
        return $this->query()->create([
            'body' => ShareService::replaceNewLineWithTag($request->body),
            'author_id' => auth()->id(),
            'commentable_id' => $model->id,
            'commentable_type' => get_class($model),
            'seen' => ShareService::checkForAdmin() ? Comment::SEEN : Comment::UNSEEN,
            'status' => ShareService::checkForAdmin() ? Comment::STATUS_ACTIVE : Comment::STATUS_INACTIVE,
            'approved' => ShareService::checkForAdmin() ? Comment::APPROVED : Comment::NOT_APPROVED,
        ]);
    }

    /**
     * @param $unSeenComments
     * @return mixed
     */
    public function makeSeenComments($unSeenComments): mixed
    {
        foreach ($unSeenComments as $unSeenComment) {
            $unSeenComment->seen = 1;
            $result = $unSeenComment->save();
        }
        return $unSeenComments;
    }

    /**
     * @param $comment
     * @return mixed
     */
    public function approveComment($comment): mixed
    {
        if ($comment->approved == Comment::NOT_APPROVED) {
            $comment->approved = Comment::APPROVED;
            $product = $comment->commentable;
            $product->comments_count += 1;
            $product->save();
        } elseif ($comment->approved == Comment::APPROVED) {
            $comment->approved = Comment::NOT_APPROVED;
            $product = $comment->commentable;
            $product->comments_count -= 1;
            $product->save();
        }
        return $comment->save();
    }

    /**
     * @param $request
     * @param $comment
     * @return Builder|Model
     */
    public function replyComment($request, $comment): Model|Builder
    {
        return $this->query()->create([
            'body' => $request->body,
            'parent_id' => $comment->id,
            'author_id' => auth()->id(),
            'commentable_id' => $comment->commentable_id,
            'commentable_type' => $comment->commentable_type,
            'approved' => Comment::APPROVED,
            'status' => Comment::STATUS_ACTIVE
        ]);
    }

    /**
     * Return comment query.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Comment::query();
    }
}
