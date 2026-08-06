<?php

namespace App\Filament\Resources\NavigationItems\Schemas;

use App\Models\NavigationItem;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NavigationItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('label'),
                TextEntry::make('url'),
                TextEntry::make('navigation_location'),
                TextEntry::make('icon')
                    ->placeholder('-'),
                IconEntry::make('open_new_tab')
                    ->boolean(),
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
                    ->visible(fn (NavigationItem $record): bool => $record->trashed()),
            ]);
    }
}
