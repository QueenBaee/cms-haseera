<?php

namespace App\Filament\Resources\CompanyStatistics\Schemas;

use App\Support\HeroiconOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CompanyStatisticForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('value')->label('Nilai')->required(), TextInput::make('prefix')->label('Awalan'), TextInput::make('suffix')->label('Akhiran'), TextInput::make('label')->label('Label')->required(), Textarea::make('description')->label('Deskripsi')->columnSpanFull(), Select::make('icon')->label('Ikon')->options(HeroiconOptions::all())->searchable()->preload()->native(false)->placeholder('Pilih ikon (opsional)'), TextInput::make('sort_order')->label('Urutan')->numeric()->required()->default(0), Toggle::make('is_active')->label('Aktif')->default(true), ]);
    }
}
