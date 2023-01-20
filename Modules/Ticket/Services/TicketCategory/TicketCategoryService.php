<?php

namespace Modules\Ticket\Services\TicketCategory;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Entities\TicketCategory;

class TicketCategoryService implements TicketCategoryServiceInterface
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

    public function update($request, $ticketCategory)
    {
        return $ticketCategory->update([
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
        return TicketCategory::query();
    }
}
