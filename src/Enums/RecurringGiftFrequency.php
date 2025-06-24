<?php

namespace BlackbaudSdk\Enums;

enum RecurringGiftFrequency: string
{
    case Weekly = 'WEEKLY';
    case EveryTwoWeeks = 'EVERY_TWO_WEEKS';
    case EveryFourWeeks = 'EVERY_FOUR_WEEKS';
    case Monthly = 'MONTHLY';
    case Quarterly = 'QUARTERLY';
    case Annually = 'ANNUALLY';
}
