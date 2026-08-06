<?php

namespace App\Filament\Resources\NavigationItems\Schemas;

use App\Enums\NavigationLocation;
use App\Rules\InternalOrExternalUrl;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NavigationItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('label')->label('Label')->required()->maxLength(255), TextInput::make('url')->label('URL')->required()->rules([new InternalOrExternalUrl]), Select::make('navigation_location')->label('Lokasi')->options(NavigationLocation::options())->required(), TextInput::make('icon')->label('Ikon'), Toggle::make('open_new_tab')->label('Buka di Tab Baru'), TextInput::make('sort_order')->label('Urutan')->numeric()->required()->default(0), Toggle::make('is_active')->label('Aktif')->default(true), ]);
    }
}
