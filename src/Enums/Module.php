<?php

namespace Blackbaud\Enums;

enum Module: string
{
    case None = 'None';
    case GeneralLedger = 'GeneralLedger';
    case AccountsPayable = 'AccountsPayable';
    case AccountsReceivable = 'AccountsReceivable';
    case FixedAssets = 'FixedAssets';
    case CashReceipts = 'CashReceipts';
}
