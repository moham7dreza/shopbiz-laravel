<?php

namespace Modules\User\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class UserRepoEloquent implements UserRepoEloquentInterface
{
    /**
     * @param $property
     * @param $dir
     * @return Builder
     */
    public function sort($property, $dir): Builder
    {
        return $this->query()->orderBy($property, $dir);
    }

    /**
     * @return Model|Collection|Builder|array|null
     */
    public function findSystemAdmin(): Model|Collection|Builder|array|null
    {
//        return $this->findById(1);
        return $this->query()->admin()->permission('permission super admin')->first();
    }

    /**
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('first_name' , 'like', '%' . $name . '%')
            ->orWhere('last_name' , 'like', '%' . $name . '%')->latest();
    }
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
        return $this->query()->admin()->where([
//            ['id', '!=', auth()->id()],
        ])->latest();
    }

    /**
     * @return Builder
     */
    public function customerUsers(): Builder
    {
        return $this->query()->user()->where([
//            ['id', '!=', auth()->id()],
        ])->latest();
    }

    /**
     * @return int
     */
    public function customerUsersCount(): int
    {
        return $this->query()->user()->count();
    }

    /**
     * @return int
     */
    public function notVerifiedCustomerUsersCount(): int
    {
        return $this->query()->user()->whereNull('email_verified_at')->orWhereNull('mobile_verified_at')->count();
    }

    /**
     * @return int
     */
    public function notActivatedCustomerUsersCount(): int
    {
        return $this->query()->user()->whereNull('activation_date')->count();
    }

    /**
     * @return int
     */
    public function adminUsersCount(): int
    {
        return $this->query()->admin()->count();
    }

    /**
     * @return int
     */
    public function notActiveAdminUsersCount(): int
    {
        return $this->query()->admin()->activate(User::NOT_ACTIVE)->orWhereNull('activation_date')->count();
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
