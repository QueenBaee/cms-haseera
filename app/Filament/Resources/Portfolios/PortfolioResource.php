<?php

namespace App\Filament\Resources\Portfolios;

use App\Filament\Resources\Portfolios\Pages\CreatePortfolio;
use App\Filament\Resources\Portfolios\Pages\EditPortfolio;
use App\Filament\Resources\Portfolios\Pages\ListPortfolios;
use App\Filament\Resources\Portfolios\Pages\ViewPortfolio;
use App\Filament\Resources\Portfolios\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\Portfolios\Schemas\PortfolioForm;
use App\Filament\Resources\Portfolios\Schemas\PortfolioInfolist;
use App\Filament\Resources\Portfolios\Tables\PortfoliosTable;
use App\Models\Portfolio;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Square2Stack;

    protected static string|\UnitEnum|null $navigationGroup = 'Website';

    protected static ?string $navigationLabel = 'Portofolio';

    protected static ?string $modelLabel = 'Portofolio';

    protected static ?string $pluralModelLabel = 'Portofolio';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return PortfolioForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PortfolioInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PortfoliosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPortfolios::route('/'),
            'create' => CreatePortfolio::route('/create'),
            'view' => ViewPortfolio::route('/{record}'),
            'edit' => EditPortfolio::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('category');
    }
}
