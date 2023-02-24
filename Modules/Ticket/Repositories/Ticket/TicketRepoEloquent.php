<?php

namespace Modules\Ticket\Repositories\Ticket;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ticket\Entities\Ticket;

class TicketRepoEloquent implements TicketRepoEloquentInterface
{
    /**
     * @param $property
     * @param $dir
     * @param $ticketType
     * @return Builder
     */
    public function sort($property, $dir, $ticketType): Builder
    {
        return match ($ticketType) {
            'newTickets' => $this->query()->new()->orderBy($property, $dir),
            'openTickets' => $this->query()->open()->orderBy($property, $dir),
            'closeTickets' => $this->query()->close()->orderBy($property, $dir),
            default => $this->query()->orderBy($property, $dir),
        };
    }

    /**
     * @param $name
     * @param $ticketType
     * @return Model|Builder|null
     */
    public function search($name, $ticketType): Model|Builder|null
    {
        return match ($ticketType) {
            'newTickets' => $this->query()->new()->where('subject', 'like', '%' . $name . '%')->orWhere('user_id', 'like', '%' . $name . '%')->latest(),
            'openTickets' => $this->query()->open()->where('subject', 'like', '%' . $name . '%')->orWhere('user_id', 'like', '%' . $name . '%')->latest(),
            'closeTickets' => $this->query()->close()->where('subject', 'like', '%' . $name . '%')->orWhere('user_id', 'like', '%' . $name . '%')->latest(),
            default => $this->query()->where('subject', 'like', '%' . $name . '%')->orWhere('user_id', 'like', '%' . $name . '%')->latest(),
        };
    }

    /**
     * @return Builder
     */
    public function newTickets(): Builder
    {
        return $this->query()->new()->latest();
    }

    /**
     * @return int
     */
    public function newTicketsCount(): int
    {
        return $this->query()->new()->count();
    }

    /**
     * @return Builder
     */
    public function openTickets(): Builder
    {
        return $this->query()->open()->latest();
    }

    /**
     * @return Builder
     */
    public function closeTickets(): Builder
    {
        return $this->query()->close()->latest();
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
