<?php

namespace Modules\Ticket\Repositories\TicketCategory;


use Illuminate\Database\Eloquent\Builder;
use Modules\Ticket\Entities\TicketCategory;

class TicketCategoryRepoEloquent implements TicketCategoryRepoEloquentInterface
{
    /**
     * Get latest products.
     *
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * Find product by id.
     *
     * @param  $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findById($id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Delete product by id.
     *
     * @param  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * Get query model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return TicketCategory::query();
    }
}
