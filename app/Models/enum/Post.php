<?php

namespace App\Models\enum;

enum Post
{
    case draft;
    case deleted;
    case published;
}
