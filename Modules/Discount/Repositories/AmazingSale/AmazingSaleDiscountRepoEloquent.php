<?php

namespace Modules\Discount\Repositories\AmazingSale;

use Illuminate\Database\Eloquent\Builder;
use Modules\Discount\Entities\AmazingSale;

class AmazingSaleDiscountRepoEloquent implements AmazingSaleDiscountRepoEloquentInterface
{
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
     * Get query for article model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return AmazingSale::query();
    }
}
