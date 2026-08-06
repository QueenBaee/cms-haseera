<?php

namespace App\Filament\Resources\PortfolioCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PortfolioCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nama')->required(), TextInput::make('slug')->label('Slug')->unique(ignoreRecord: true), Textarea::make('description')->label('Deskripsi')->columnSpanFull(), TextInput::make('sort_order')->label('Urutan')->numeric()->required()->default(0), Toggle::make('is_active')->label('Aktif')->default(true), ]);
    }
}
