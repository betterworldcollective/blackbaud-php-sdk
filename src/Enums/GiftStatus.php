<?php

namespace BlackbaudSdk\Enums;

enum GiftStatus: string
{
    case Active = 'Active';
    case Held = 'Held';
    case Terminated = 'Terminated';
    case Completed = 'Completed';
    case Cancelled = 'Cancelled';
}
