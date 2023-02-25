<?php

namespace Modules\Ticket\Services\Ticket;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Entities\TicketFile;
use Modules\Ticket\Notifications\NewTicketRegistered;

class TicketService implements TicketServiceInterface
{
    /**
     * @param $tickets
     * @return void
     */
    public function makeSeenTickets($tickets): void
    {
        foreach ($tickets as $newTicket) {
            $newTicket->seen = Ticket::STATUS_SEEN_TICKET;
            $result = $newTicket->save();
        }
    }

    /**
     * @param $request
     * @param $ticket
     * @param string $type
     * @return Model|Builder
     */
    public function store($request, $ticket = null, string $type = 'admin'): Model|Builder
    {
        return $this->query()->create([
            'subject' => isset($ticket) ? $ticket->subject : $request->subject,
            'description' => $request->description,
            'seen' => ($type == 'admin' ? Ticket::STATUS_SEEN_TICKET : Ticket::STATUS_UN_SEEN_TICKET),
            'status' => Ticket::STATUS_OPEN_TICKET,
            'reference_id' => $ticket?->reference_id,
            'user_id' => auth()->id(),
            'category_id' => isset($ticket) ? $ticket->category_id : $request->category_id,
            'priority_id' => isset($ticket) ? $ticket->priority_id : $request->priority_id,
            'ticket_id' => $ticket?->id,
        ]);
    }

    /**
     * @param $adminUser
     * @param $ticketId
     * @return void
     */
    public function sendTicketCreatedNotificationToAdmin($adminUser, $ticketId): void
    {
        $details = [
            'message' => 'یک تیکت جدید ثبت شد.',
            'ticket_id' => $ticketId,
        ];
        $adminUser->notify(new NewTicketRegistered($details));
    }

    /**
     * @param $ticket
     * @return void
     */
    public function changeTicketStatus($ticket): void
    {
        $ticket->status = $ticket->status == Ticket::STATUS_OPEN_TICKET ? Ticket::STATUS_CLOSE_TICKET : Ticket::STATUS_OPEN_TICKET;
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
