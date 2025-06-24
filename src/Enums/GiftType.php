<?php

namespace Blackbaud\Enums;

enum GiftType: string
{
    case Donation = 'Donation';
    case Other = 'Other';
    case GiftInKind = 'GiftInKind';
    case RecurringGift = 'RecurringGift';
    case RecurringGiftPayment = 'RecurringGiftPayment';
    case PledgePayment = 'PledgePayment';
}
