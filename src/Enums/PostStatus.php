<?php

namespace BlackbaudSdk\Enums;

enum PostStatus: string
{
    case Posted = 'Posted';
    case NotPosted = 'NotPosted';
    case DoNotPost = 'DoNotPost';
}
