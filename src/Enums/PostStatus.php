<?php

namespace Blackbaud\Enums;

enum PostStatus: string
{
    case Posted = 'Posted';
    case NotPosted = 'NotPosted';
    case DoNotPost = 'DoNotPost';
}
