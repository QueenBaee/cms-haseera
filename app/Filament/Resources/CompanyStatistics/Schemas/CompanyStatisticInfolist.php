<?php

namespace App\Filament\Resources\CompanyStatistics\Schemas;

use App\Models\CompanyStatistic;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CompanyStatisticInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('value'),
                TextEntry::make('prefix')
                    ->placeholder('-'),
                TextEntry::make('suffix')
                    ->placeholder('-'),
                TextEntry::make('label'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
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
                    ->visible(fn (CompanyStatistic $record): bool => $record->trashed()),
            ]);
    }
}
