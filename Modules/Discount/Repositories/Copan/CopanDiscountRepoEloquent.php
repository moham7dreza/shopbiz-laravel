<?php

namespace Modules\Discount\Repositories\Copan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Discount\Entities\Copan;

class CopanDiscountRepoEloquent implements CopanDiscountRepoEloquentInterface
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
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('code' , 'like', '%' . $name . '%')->latest();
    }

    /**
     * Get latest discounts.
     *
     * @return Builder
     */
    public function getLatest(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * @param string $date
     * @param string $direction
     * @return Builder
     */
    public function getLatestOrderByDate(string $date = 'end_date', string $direction = 'desc'): Builder
    {
        return $this->query()->orderBy($date, $direction)->latest();
    }

    // home

    /**
     * @param $code
     * @return Model|Builder|null
     */
    public function findActiveCopanDiscountWithCode($code): Model|Builder|null
    {
        return $this->query()->alreadyActive()->where('code', $code)->first();
    }

    /**
     * @param $code
     * @return Model|Builder|null
     */
    public function findActiveCopanDiscountWithCodeAssignedForUser($code): Model|Builder|null
    {
        return $this->query()->alreadyActive()->where([
            ['code', $code],
            ['user_id', auth()->id()]
        ])->first();
    }

    /**
     * panel
     * @return Model|Builder|null
     */
    public function activeCopanDiscounts(): Model|Builder|null
    {
        return $this->query()->alreadyActive()->latest();
    }

    /**
     * Find by id.
     *
     * @param  int|string $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findById(int $id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Get query for article model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Copan::query();
    }
}
