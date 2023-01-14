<?php

namespace Modules\Cart\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Cart\Entities\CartItem;

class CartRepoEloquent implements CartRepoEloquentInterface
{
    /**
     * @return Builder
     */
    public function findUserCartItems(): Builder
    {
        return $this->query()->where('user_id', auth()->id())->latest();
    }

    /**
     * @param $id
     * @return Builder
     */
    public function findUserCartItemsWithRelatedProduct($id): Builder
    {
        return $this->query()->where([
            ['user_id', auth()->id()],
            ['product_id', $id],
        ])->latest();
    }

    /**
     * Find role by id.
     *
     * @param  $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Delete role by id.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * Builder for queue model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return CartItem::query();
    }
}
