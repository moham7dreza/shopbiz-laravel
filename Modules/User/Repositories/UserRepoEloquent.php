<?php

namespace Modules\User\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class UserRepoEloquent implements UserRepoEloquentInterface
{
    /**
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * @return Builder
     */
    public function adminUsers(): Builder
    {
        return $this->query()->where([
//            ['id', '!=', auth()->id()],
            ['user_type', 1]
        ])->latest();
    }

    /**
     * @return Builder
     */
    public function customerUsers(): Builder
    {
        return $this->query()->where([
//            ['id', '!=', auth()->id()],
            ['user_type', 0]
        ])->latest();
    }

    /**
     * @return int
     */
    public function customerUsersCount(): int
    {
        return $this->query()->where([
            ['user_type', 0]
        ])->count();
    }

    /**
     * @return int
     */
    public function adminUsersCount(): int
    {
        return $this->query()->where([
            ['user_type', 1]
        ])->count();
    }

    /**
     * Get the latest users without id.
     *
     * @param int $id
     * @return Builder
     */
    public function getLatestWithoutId(int $id): Builder
    {
        return $this->query()->where('id', '!=', $id)->latest();
    }

    /**
     * Find user by email address.
     *
     * @param string $email
     * @return Builder|Model|null
     *
     */
    public function findByEmail(string $email): Model|Builder|null
    {
        return $this->query()->where('email', $email)->first();
    }

    /**
     * @param string $mobile
     * @return Model|Builder|null
     */
    public function findByMobile(string $mobile): Model|Builder|null
    {
        return $this->query()->where('mobile', $mobile)->first();
    }

    /**
     * Find user by id.
     *
     * @param int $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function findById(int $id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Delete user by id.
     *
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * Get model(User) query, builder.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return User::query();
    }
}
