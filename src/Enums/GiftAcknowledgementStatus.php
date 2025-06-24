<?php

namespace BlackbaudSdk\Enums;

enum GiftAcknowledgementStatus: string
{
    case Acknowledged = 'ACKNOWLEDGED';
    case NeedsAcknowledgement = 'NEEDSACKNOWLEDGEMENT';
    case DoNotAcknowledge = 'DONOTACKNOWLEDGE';
}
