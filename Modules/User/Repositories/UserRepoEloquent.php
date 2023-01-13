<?php

namespace Modules\User\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\User\Entities\User;

class UserRepoEloquent implements UserRepoEloquentInterface
{
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
     * Get the latest users without id.
     *
     * @param int $id
     * @return Builder
     */
    public function getLatestWithoutId(int $id)
    {
        return $this->query()->where('id', '!=', $id)->latest();
    }

    /**
     * Find user by email address.
     *
     * @param string $email
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|null
     *
     */
    public function findByEmail(string $email)
    {
        return $this->query()->where('email', $email)->first();
    }

    /**
     * Find user by id.
     *
     * @param int $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
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
