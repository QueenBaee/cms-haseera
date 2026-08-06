<?php

namespace App\Filament\Resources\PortfolioCategories;

use App\Filament\Resources\PortfolioCategories\Pages\CreatePortfolioCategory;
use App\Filament\Resources\PortfolioCategories\Pages\EditPortfolioCategory;
use App\Filament\Resources\PortfolioCategories\Pages\ListPortfolioCategories;
use App\Filament\Resources\PortfolioCategories\Pages\ViewPortfolioCategory;
use App\Filament\Resources\PortfolioCategories\Schemas\PortfolioCategoryForm;
use App\Filament\Resources\PortfolioCategories\Schemas\PortfolioCategoryInfolist;
use App\Filament\Resources\PortfolioCategories\Tables\PortfolioCategoriesTable;
use App\Models\PortfolioCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PortfolioCategoryResource extends Resource
{
    protected static ?string $model = PortfolioCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Landing Page';

    protected static ?string $navigationLabel = 'Kategori Portofolio';

    protected static ?string $modelLabel = 'Kategori Portofolio';

    protected static ?string $pluralModelLabel = 'Kategori Portofolio';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return PortfolioCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PortfolioCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PortfolioCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPortfolioCategories::route('/'),
            'create' => CreatePortfolioCategory::route('/create'),
            'view' => ViewPortfolioCategory::route('/{record}'),
            'edit' => EditPortfolioCategory::route('/{record}/edit'),
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
