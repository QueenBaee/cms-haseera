<?php

namespace App\Filament\Resources\AboutSections;

use App\Filament\Resources\AboutSections\Pages\CreateAboutSection;
use App\Filament\Resources\AboutSections\Pages\EditAboutSection;
use App\Filament\Resources\AboutSections\Pages\ListAboutSections;
use App\Filament\Resources\AboutSections\Pages\ViewAboutSection;
use App\Filament\Resources\AboutSections\RelationManagers\FeaturesRelationManager;
use App\Filament\Resources\AboutSections\Schemas\AboutSectionForm;
use App\Filament\Resources\AboutSections\Schemas\AboutSectionInfolist;
use App\Filament\Resources\AboutSections\Tables\AboutSectionsTable;
use App\Models\AboutSection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Landing Page';

    protected static ?string $navigationLabel = 'Tentang Kami';

    protected static ?string $modelLabel = 'Bagian Tentang';

    protected static ?string $pluralModelLabel = 'Tentang Kami';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return AboutSectionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AboutSectionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AboutSectionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            FeaturesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAboutSections::route('/'),
            'create' => CreateAboutSection::route('/create'),
            'view' => ViewAboutSection::route('/{record}'),
            'edit' => EditAboutSection::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
