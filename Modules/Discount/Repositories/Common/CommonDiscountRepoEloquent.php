<?php

namespace Modules\Discount\Repositories\Common;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Discount\Entities\CommonDiscount;

class CommonDiscountRepoEloquent implements CommonDiscountRepoEloquentInterface
{
    /**
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('percentage', $name)->orWhere('title' , 'like', '%' . $name . '%')->latest();
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
     * @return Model|Builder|null
     */
    public function activeCommonDiscount(): Model|Builder|null
    {
        return $this->query()->alreadyActive()->first();
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
