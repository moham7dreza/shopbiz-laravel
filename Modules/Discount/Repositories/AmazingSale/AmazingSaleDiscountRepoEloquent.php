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
     * panel
     * @return int
     */
    public function activeAmazingSalesCount(): int
    {
        return $this->activeAmazingSales()->count();
    }

    /**
     * @param $productID
     * @return Model|Builder|null
     */
    public function activeAmazingSales($productID = null): Model|Builder|null
    {
        $query = $this->query()->alreadyActive();
        return is_null($productID) ? $query->latest() : $query->where('product_id', $productID)->latest();
    }

    /**
     * home
     * @param $percentage
     * @return Builder
     */
    public function bestOffers($percentage): Builder
    {
        return $this->activeAmazingSales()->where('percentage', '>=', $percentage)->latest();
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
