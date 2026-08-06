<?php

declare(strict_types=1);

namespace App\Enums;

enum ServiceDisplayVariant: string
{
    case Card = 'card';
    case Horizontal = 'horizontal';
    case ImageTop = 'image_top';
    case ImageLeft = 'image_left';
    case ImageRight = 'image_right';

    public static function options(): array
    {
        return [
            self::Card->value => 'Card',
            self::Horizontal->value => 'Horizontal',
            self::ImageTop->value => 'Gambar di Atas',
            self::ImageLeft->value => 'Gambar di Kiri',
            self::ImageRight->value => 'Gambar di Kanan',
        ];
    }
}
