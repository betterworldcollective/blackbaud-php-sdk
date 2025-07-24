<?php

namespace Blackbaud\Enums;

enum CustomFieldCategoryType: string
{
    case Text = 'Text';
    case Date = 'Date';
    case Currency = 'Currency';
    case Boolean = 'Boolean';
    case CodeTableEntry = 'CodeTableEntry';
    case ConstituentId = 'ConstituentId';
    case FuzzyDate = 'FuzzyDate';
    case Number = 'Number';
}
