<?php

namespace BlackbaudSdk\Enums;

enum GiftPaymentMethod: string
{
    case Cash = 'Cash';
    case CreditCard = 'CreditCard';
    case PersonalCheck = 'PersonalCheck';
    case DirectDebit = 'DirectDebit';
    case Other = 'Other';
    case PayPal = 'PayPal';
    case Venmo = 'Venmo';
}
