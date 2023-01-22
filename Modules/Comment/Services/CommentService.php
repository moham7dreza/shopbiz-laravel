<?php

namespace Modules\Comment\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Repositories\RolePermissionRepoEloquentInterface;
use Modules\Comment\Entities\Comment;
use Modules\Comment\Repositories\CommentRepoEloquentInterface;
use Modules\Share\Services\ShareService;

class CommentService
{
    public RolePermissionRepoEloquentInterface $permissionRepo;

    public function __construct(RolePermissionRepoEloquentInterface $permissionRepo)
    {
        $this->permissionRepo = $permissionRepo;
    }

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
            'seen' => $this->checkForAdmin() ? Comment::SEEN : Comment::UNSEEN,
            'status' => $this->checkForAdmin() ? Comment::STATUS_ACTIVE : Comment::STATUS_INACTIVE,
            'approved' => $this->checkForAdmin() ? Comment::APPROVED : Comment::NOT_APPROVED,
        ]);
    }

    /**
     * @return bool
     */
    public function checkForAdmin(): bool
    {
        $permission = $this->permissionRepo->findByName(get_per_name(Permission::PERMISSION_SUPER_ADMIN));
         return (bool)auth()->user()->hasPermissionTo($permission);
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
