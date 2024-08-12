<?php

namespace App\Enum;

enum InvoiceStatus: string
{
    case PENDING = 'pending'; // The invoice has been issued but not yet paid.
    case PAID = 'paid'; // The invoice has been fully paid.
    case OVERDUE = 'overdue'; // The payment deadline has passed, and the invoice is still unpaid.
    case CANCELLED = 'cancelled'; // The invoice was issued but later cancelled.
}