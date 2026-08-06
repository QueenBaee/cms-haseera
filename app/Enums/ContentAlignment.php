<?php

declare(strict_types=1);

namespace App\Enums;

enum ContentAlignment: string
{
    case Left = 'left';
    case Center = 'center';
    case Right = 'right';

    public static function options(): array
    {
        return [
            self::Left->value => 'Kiri',
            self::Center->value => 'Tengah',
            self::Right->value => 'Kanan',
        ];
    }
}
