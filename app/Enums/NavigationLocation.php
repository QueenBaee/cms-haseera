<?php

declare(strict_types=1);

namespace App\Enums;

enum NavigationLocation: string
{
    case Header = 'header';
    case Footer = 'footer';
    case Both = 'both';

    public static function options(): array
    {
        return [
            self::Header->value => 'Header',
            self::Footer->value => 'Footer',
            self::Both->value => 'Keduanya',
        ];
    }
}
