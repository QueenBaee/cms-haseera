<?php

namespace App\Filament\Resources\AboutSections\Schemas;

use App\Models\AboutSection;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AboutSectionInfolist
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
                TextEntry::make('short_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('image')
                    ->placeholder('-'),
                ImageEntry::make('secondary_image')
                    ->placeholder('-'),
                TextEntry::make('video_url')
                    ->placeholder('-'),
                TextEntry::make('button_text')
                    ->placeholder('-'),
                TextEntry::make('button_url')
                    ->placeholder('-'),
                IconEntry::make('button_new_tab')
                    ->boolean(),
                TextEntry::make('content_position'),
                TextEntry::make('sort_order')
                    ->numeric(),
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
                    ->visible(fn (AboutSection $record): bool => $record->trashed()),
            ]);
    }
}
