<?php

namespace Modules\Ticket\Repositories\Ticket;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ticket\Entities\Ticket;

class TicketRepoEloquent implements TicketRepoEloquentInterface
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
     * @return Builder
     */
    public function newTickets(): Builder
    {
        return $this->query()->where('seen', 0)->latest();
    }

    /**
     * @return int
     */
    public function newTicketsCount(): int
    {
        return $this->query()->where('seen', 0)->count();
    }

    /**
     * @return Builder
     */
    public function openTickets(): Builder
    {
        return $this->query()->where('status', 0)->latest();
    }

    /**
     * @return Builder
     */
    public function closeTickets(): Builder
    {
        return $this->query()->where('status', 1)->latest();
    }

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
        return Ticket::query();
    }
}
