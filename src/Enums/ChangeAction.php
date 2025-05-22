<?php

declare(strict_types=1);

namespace OneOne8\LaravelAware\Enums;

enum ChangeAction: string
{
    case CREATE = 'create';
    case DELETE = 'delete';
    case FORCE_DELETE = 'force_delete';
    case RESTORE = 'restore';
    case UPDATE = 'update';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
