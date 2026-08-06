<?php

declare(strict_types=1);

namespace App\Enums;

enum AboutContentPosition: string
{
    case ImageLeft = 'image_left';
    case ImageRight = 'image_right';

    public static function options(): array
    {
        return [
            self::ImageLeft->value => 'Gambar di Kiri',
            self::ImageRight->value => 'Gambar di Kanan',
        ];
    }
}
