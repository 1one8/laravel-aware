<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Enums;

enum ChangedUsing: string
{
    case API = 'api';
    case WEB = 'web';
    case CONSOLE = 'console';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
