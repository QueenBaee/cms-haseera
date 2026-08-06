<?php

declare(strict_types=1);

namespace App\Enums;

enum VerticalAlignment: string
{
    case Top = 'top';
    case Center = 'center';
    case Bottom = 'bottom';

    public static function options(): array
    {
        return [
            self::Top->value => 'Atas',
            self::Center->value => 'Tengah',
            self::Bottom->value => 'Bawah',
        ];
    }
}
