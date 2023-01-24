<?php

namespace Modules\Ticket\Enums;

enum TicketSeenEnum:int
{
    case STATUS_SEEN_TICKET = 1;
    case STATUS_UN_SEEN_TICKET = 0;
}
