<?php

namespace Modules\Ticket\Enums;

enum TicketStatusEnum:int
{
    case STATUS_OPEN_TICKET = 1;
    case STATUS_CLOSE_TICKET = 0;
}
