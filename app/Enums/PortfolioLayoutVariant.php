<?php

declare(strict_types=1);

namespace App\Enums;

enum PortfolioLayoutVariant: string
{
    case ImageLeft = 'image_left';
    case ImageRight = 'image_right';
    case ImageTop = 'image_top';
    case ImageBottom = 'image_bottom';
    case Wide = 'wide';
    case Compact = 'compact';
    case Featured = 'featured';

    public static function options(): array
    {
        return [
            self::ImageLeft->value => 'Gambar di Kiri',
            self::ImageRight->value => 'Gambar di Kanan',
            self::ImageTop->value => 'Gambar di Atas',
            self::ImageBottom->value => 'Gambar di Bawah',
            self::Wide->value => 'Lebar',
            self::Compact->value => 'Kompak',
            self::Featured->value => 'Featured',
        ];
    }
}
