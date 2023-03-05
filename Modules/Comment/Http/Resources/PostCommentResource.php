<?php

namespace Modules\Comment\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCommentResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'message' => 'داده های مربوطه به کامنت پست ها',
            'status' => 'success',
            'count' => count($this->collection),
            'data' => $this->collection->map(function ($comment) {
                return [
                    'comment_author' => $comment->getAuthorName(),
                    'comment_body' => $comment->body,
                    'comment_parent' => $comment->getParentBody(),
//                    'comment_answers' => $comment->answers,
                    'comment_approved' => $comment->getFaApproved(),
                    'commentable_name' => $comment->commentable->title,
                    'comment_created_date' => $comment->getFaCreatedDate(true),
                    'comment_updated_date' => $comment->getFaUpdatedDate(true)
                ];
            }),
        ];
    }
}
