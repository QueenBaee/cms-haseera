<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use App\Models\Testimonial;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TestimonialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('position')
                    ->placeholder('-'),
                TextEntry::make('company')
                    ->placeholder('-'),
                TextEntry::make('photo')
                    ->placeholder('-'),
                TextEntry::make('content')
                    ->columnSpanFull(),
                TextEntry::make('rating')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('source')
                    ->placeholder('-'),
                TextEntry::make('source_url')
                    ->placeholder('-'),
                TextEntry::make('card_variant'),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_featured')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Testimonial $record): bool => $record->trashed()),
            ]);
    }
}
