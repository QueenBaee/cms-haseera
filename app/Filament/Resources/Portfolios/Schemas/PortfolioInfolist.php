<?php

namespace App\Filament\Resources\Portfolios\Schemas;

use App\Models\Portfolio;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PortfolioInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('portfolio_category_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('eyebrow')
                    ->placeholder('-'),
                TextEntry::make('client_name')
                    ->placeholder('-'),
                TextEntry::make('project_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('location')
                    ->placeholder('-'),
                TextEntry::make('short_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('thumbnail')
                    ->placeholder('-'),
                ImageEntry::make('cover_image')
                    ->placeholder('-'),
                TextEntry::make('logo')
                    ->placeholder('-'),
                TextEntry::make('project_url')
                    ->placeholder('-'),
                TextEntry::make('button_text')
                    ->placeholder('-'),
                TextEntry::make('layout_variant'),
                ImageEntry::make('image_fit'),
                TextEntry::make('content_alignment'),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_featured')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('meta_title')
                    ->placeholder('-'),
                TextEntry::make('meta_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Portfolio $record): bool => $record->trashed()),
            ]);
    }
}
