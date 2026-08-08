<?php

namespace App\Filament\Resources\SocialMediaLinks\Schemas;

use App\Rules\InternalOrExternalUrl;
use App\Support\HeroiconOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SocialMediaLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('platform')->label('Platform')->required(), TextInput::make('label')->label('Label'), TextInput::make('url')->label('URL')->required()->rules([new InternalOrExternalUrl]), Select::make('icon')->label('Ikon')->options(HeroiconOptions::all())->searchable()->preload()->native(false)->placeholder('Pilih ikon (opsional)'), TextInput::make('sort_order')->label('Urutan')->numeric()->required()->default(0), Toggle::make('is_active')->label('Aktif')->default(true), ]);
    }
}
