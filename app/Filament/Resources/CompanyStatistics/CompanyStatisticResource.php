<?php

namespace App\Filament\Resources\CompanyStatistics;

use App\Filament\Resources\CompanyStatistics\Pages\CreateCompanyStatistic;
use App\Filament\Resources\CompanyStatistics\Pages\EditCompanyStatistic;
use App\Filament\Resources\CompanyStatistics\Pages\ListCompanyStatistics;
use App\Filament\Resources\CompanyStatistics\Pages\ViewCompanyStatistic;
use App\Filament\Resources\CompanyStatistics\Schemas\CompanyStatisticForm;
use App\Filament\Resources\CompanyStatistics\Schemas\CompanyStatisticInfolist;
use App\Filament\Resources\CompanyStatistics\Tables\CompanyStatisticsTable;
use App\Models\CompanyStatistic;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyStatisticResource extends Resource
{
    protected static ?string $model = CompanyStatistic::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Landing Page';

    protected static ?string $navigationLabel = 'Statistik Perusahaan';

    protected static ?string $modelLabel = 'Statistik';

    protected static ?string $pluralModelLabel = 'Statistik Perusahaan';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return CompanyStatisticForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CompanyStatisticInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompanyStatisticsTable::configure($table);
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
            'index' => ListCompanyStatistics::route('/'),
            'create' => CreateCompanyStatistic::route('/create'),
            'view' => ViewCompanyStatistic::route('/{record}'),
            'edit' => EditCompanyStatistic::route('/{record}/edit'),
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
