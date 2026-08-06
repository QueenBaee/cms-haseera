<?php

declare(strict_types=1);

namespace App\Enums;

enum ImageFit: string
{
    case Cover = 'cover';
    case Contain = 'contain';

    public static function options(): array
    {
        return [
            self::Cover->value => 'Cover',
            self::Contain->value => 'Contain',
        ];
    }
}
