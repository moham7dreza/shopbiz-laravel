<?php

namespace Modules\Auth\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\Otp;

class AuthRepoEloquent implements AuthRepoEloquentInterface
{
    /**
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * Find user by id.
     *
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById(int $id): Model|Collection|Builder|array|null
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * @param string $token
     * @return Builder|Model|null
     */
    public function findByToken(string $token): Model|Builder|null
    {
        return $this->query()->where('token', $token)->first();
    }

    /**
     * @param string $token
     * @return Builder|Model|null
     */
    public function findValidOtp(string $token): Model|Builder|null
    {
        return $this->query()->where([
            ['token', $token],
            ['used', 0],
            ['created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString()]
        ])->first();
    }

    /**
     * @param string $token
     * @return Builder|Model|null
     */
    public function findExpiredOtp(string $token): Model|Builder|null
    {
        return $this->query()->where([
            ['token', $token],
            ['created_at', '<=', Carbon::now()->subMinute(5)->toDateTimeString()]
        ])->first();
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
        return Otp::query();
    }
}
