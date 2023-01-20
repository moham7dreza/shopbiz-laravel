<?php

namespace Modules\Ticket\Services\TicketPriority;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ticket\Entities\TicketPriority;

class TicketPriorityService implements TicketPriorityServiceInterface
{
    /**
     * @param $request
     * @return Model|Builder
     */
    public function store($request): Model|Builder
    {
        return $this->query()->create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
    }

    public function update($request, $ticketPriority)
    {
        return $ticketPriority->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);
    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return TicketPriority::query();
    }
}
