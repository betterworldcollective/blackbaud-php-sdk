<?php

namespace Blackbaud\Enums;

enum QueryTypeId: int
{
    case Action = 38;
    case Appeal = 7;
    case Campaign = 1;
    case Constituent = 18;
    case Event = 29;
    case Fund = 6;
    case Gift = 20;
    case Individual = 35;
    case Job = 24;
    case Membership = 34;
    case Organization = 36;
    case Participant = 33;
    case Relationship = 40;
}
