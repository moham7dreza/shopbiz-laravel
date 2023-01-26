<?php

namespace Modules\Discount\Repositories\AmazingSale;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Discount\Entities\AmazingSale;

class AmazingSaleDiscountRepoEloquent implements AmazingSaleDiscountRepoEloquentInterface
{

    /**
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('percentage', $name)->latest();
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
     * @return int
     */
    public function activeAmazingSalesCount(): int
    {
        return AmazingSale::query()->where([
            ['start_date', '<', Carbon::now()],
            ['end_date', '>', Carbon::now()],
            ['status', AmazingSale::STATUS_ACTIVE]
        ])->count();
    }

    /**
     * @param $percentage
     * @return Builder
     */
    public function bestOffers($percentage): Builder
    {
        return AmazingSale::query()->where([
            ['start_date', '<', Carbon::now()],
            ['end_date', '>', Carbon::now()],
            ['status', AmazingSale::STATUS_ACTIVE],
            ['percentage', '>=', $percentage]
        ])->latest();
    }

    /**
     * Get query for article model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return AmazingSale::query();
    }
}
