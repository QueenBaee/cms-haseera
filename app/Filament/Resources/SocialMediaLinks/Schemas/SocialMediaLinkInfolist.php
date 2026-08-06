<?php

namespace App\Filament\Resources\SocialMediaLinks\Schemas;

use App\Models\SocialMediaLink;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SocialMediaLinkInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('platform'),
                TextEntry::make('label')
                    ->placeholder('-'),
                TextEntry::make('url'),
                TextEntry::make('icon')
                    ->placeholder('-'),
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
                    ->visible(fn (SocialMediaLink $record): bool => $record->trashed()),
            ]);
    }
}
