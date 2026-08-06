<?php

declare(strict_types=1);

namespace App\Enums;

enum TestimonialCardVariant: string
{
    case Standard = 'standard';
    case Compact = 'compact';
    case Featured = 'featured';

    public static function options(): array
    {
        return [
            self::Standard->value => 'Standard',
            self::Compact->value => 'Compact',
            self::Featured->value => 'Featured',
        ];
    }
}
