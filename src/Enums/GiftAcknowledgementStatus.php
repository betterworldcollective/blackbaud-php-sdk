<?php

namespace Blackbaud\Enums;

enum GiftAcknowledgementStatus: string
{
    case Acknowledged = 'ACKNOWLEDGED';
    case NeedsAcknowledgement = 'NEEDSACKNOWLEDGEMENT';
    case DoNotAcknowledge = 'DONOTACKNOWLEDGE';
}
