<?php

namespace App\Filament\Resources\HeroSlides\Schemas;

use App\Models\HeroSlide;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class HeroSlideInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('eyebrow')
                    ->placeholder('-'),
                TextEntry::make('title'),
                TextEntry::make('highlighted_text')
                    ->placeholder('-'),
                TextEntry::make('subtitle')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('desktop_image')
                    ->placeholder('-'),
                ImageEntry::make('mobile_image')
                    ->placeholder('-'),
                ImageEntry::make('background_image')
                    ->placeholder('-'),
                TextEntry::make('primary_button_text')
                    ->placeholder('-'),
                TextEntry::make('primary_button_url')
                    ->placeholder('-'),
                IconEntry::make('primary_button_new_tab')
                    ->boolean(),
                TextEntry::make('secondary_button_text')
                    ->placeholder('-'),
                TextEntry::make('secondary_button_url')
                    ->placeholder('-'),
                IconEntry::make('secondary_button_new_tab')
                    ->boolean(),
                TextEntry::make('content_alignment'),
                TextEntry::make('vertical_alignment'),
                TextEntry::make('overlay_opacity')
                    ->numeric(),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('published_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (HeroSlide $record): bool => $record->trashed()),
            ]);
    }
}
