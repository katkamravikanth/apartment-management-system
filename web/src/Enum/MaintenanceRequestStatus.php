<?php

namespace App\Enum;

enum MaintenanceRequestStatus: string
{
    case OPEN = 'open'; // The maintenance request has been submitted but not yet addressed.
    case IN_PROGRESS = 'in_progress'; // Work on the maintenance request has started.
    case CLOSED = 'closed'; // The maintenance request has been completed and resolved.
    case CANCELLED = 'cancelled'; // The maintenance request was submitted but later cancelled.
}