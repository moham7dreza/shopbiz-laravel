<?php

namespace Modules\Comment\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Comment\Entities\Comment;
use Illuminate\Database\Eloquent\Builder;
use Modules\Share\Traits\SuccessToastMessageWithRedirectTrait;

class CommentService
{
    /**
     * @param $unSeenComments
     * @return mixed
     */
    public function makeSeenComments($unSeenComments): mixed
    {
        foreach ($unSeenComments as $unSeenComment){
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
        $comment->approved = $comment->approved == 0 ? 1 : 0;
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
            'approved' => 1,
            'status' => 1
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
