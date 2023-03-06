<?php

namespace Modules\User\Http\Controllers\Api;

use Modules\User\Http\Resources\UserResource;
use Modules\User\Repositories\UserRepoEloquentInterface;
use Modules\User\Services\UserService;

class ApiUserController
{
    public UserRepoEloquentInterface $repo;
    public UserService $service;

    /**
     * @param UserRepoEloquentInterface $userRepoEloquent
     * @param UserService $userService
     */
    public function __construct(UserRepoEloquentInterface $userRepoEloquent, UserService $userService)
    {
        $this->repo = $userRepoEloquent;
        $this->service = $userService;
    }

    /**
     * @return UserResource
     */
    public function index(): UserResource
    {
        $users = $this->repo->index()->get();
        return new UserResource($users);
    }
}
