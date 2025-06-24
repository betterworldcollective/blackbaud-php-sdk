<?php

namespace BlackbaudSdk\Enums;

enum GiftReceiptStatus: string
{
    case Receipted = 'RECEIPTED';
    case NeedsReceipt = 'NEEDSRECEIPT';
    case DoNotReceipt = 'DONOTRECEIPT';
}
