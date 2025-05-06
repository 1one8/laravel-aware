<?php

declare(strict_types=1);

namespace OneOne8\LaravelChanges\Enums;

enum ChangedUsing: string
{
    case API = 'api';
    case WEB = 'web';
    case CONSOLE = 'console';
}
