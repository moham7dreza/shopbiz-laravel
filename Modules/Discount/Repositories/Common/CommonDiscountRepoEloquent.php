<?php

namespace Modules\Discount\Repositories\Common;

use Illuminate\Database\Eloquent\Builder;
use Modules\Discount\Entities\CommonDiscount;

class CommonDiscountRepoEloquent implements CommonDiscountRepoEloquentInterface
{
    /**
     * Get latest discounts.
     *
     * @return Builder
     */
    public function getLatest()
    {
        return $this->query()->latest();
    }

    /**
     * Find by id.
     *
     * @param  int|string $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findById(int|string $id)
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
        return CommonDiscount::query();
    }
}
