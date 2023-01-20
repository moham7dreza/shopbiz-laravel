<?php

namespace Modules\Ticket\Services\Ticket;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ticket\Entities\Ticket;

class TicketService implements TicketServiceInterface
{
    /**
     * @param $tickets
     * @return void
     */
    public function makeSeenTickets($tickets): void
    {
        foreach ($tickets as $newTicket) {
            $newTicket->seen = 1;
            $result = $newTicket->save();
        }
    }

    /**
     * @param $request
     * @param $ticket
     * @return Model|Builder
     */
    public function store($request, $ticket): Model|Builder
    {
        return $this->query()->create([
            'subject' => $ticket->subject,
            'description' => $request->description,
            'seen' => Ticket::STATUS_SEEN_TICKET,
            'reference_id' => $ticket->reference_id,
            'user_id' => auth()->id(),
            'category_id' => $ticket->category_id,
            'priority_id' => $ticket->priority_id,
            'ticket_id' => $ticket->id,
        ]);
    }

    /**
     * @param $ticket
     * @return void
     */
    public function changeTicketStatus($ticket): void
    {
        $ticket->status = $ticket->status == 0 ? 1 : 0;
        $result = $ticket->save();
    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Ticket::query();
    }
}
