<?php namespace App\Enums;

enum TicketEnum: string
{
    case OPEN = 'open';
    case RESOLVED = 'resolved';
    case REJECTED = 'rejected';
}
