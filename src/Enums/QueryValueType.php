<?php

namespace Blackbaud\Enums;

enum QueryValueType: string
{
    case Text = 'Text';
    case Boolean = 'Boolean';
    case Date = 'Date';
    case FuzzyDate = 'FuzzyDate';
    case TableEntry = 'TableEntry';
    case Lookup = 'Lookup';
    case Search = 'Search';
    case StaticEntry = 'StaticEntry';
    case Summary = 'Summary';
    case FESummaryDate = 'FESummaryDate';
}
