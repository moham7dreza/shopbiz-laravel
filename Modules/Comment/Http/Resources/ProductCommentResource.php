<?php

namespace Modules\Comment\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCommentResource extends ResourceCollection
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
            'message' => 'داده های مربوطه به کامنت محصولات',
            'status' => 'success',
            'count' => count($this->collection),
            'data' => $this->collection->map(function ($comment) {
                return [
                    'comment_author' => $comment->user->fullName,
                    'comment_body' => $comment->body,
                    'comment_parent' => $comment->parent_id == null ? 'کامنت اصلی' : 'جواب کامنت',
//                    'comment_answers' => $comment->answers,
                    'comment_approved' => $comment->approved == 1 ? 'تایید شده' : 'تایید نشده',
                    'comment_product' => $comment->commentable_type::findOrFail($comment->commentable_id)->name,
                    'comment_created_date' => jalaliDate($comment->created_at),
                    'comment_updated_date' => jalaliDate($comment->updated_at),
                ];
            }),
        ];
    }
}
