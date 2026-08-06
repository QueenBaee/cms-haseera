<?php

namespace App\Filament\Resources\SocialMediaLinks;

use App\Filament\Resources\SocialMediaLinks\Pages\CreateSocialMediaLink;
use App\Filament\Resources\SocialMediaLinks\Pages\EditSocialMediaLink;
use App\Filament\Resources\SocialMediaLinks\Pages\ListSocialMediaLinks;
use App\Filament\Resources\SocialMediaLinks\Pages\ViewSocialMediaLink;
use App\Filament\Resources\SocialMediaLinks\Schemas\SocialMediaLinkForm;
use App\Filament\Resources\SocialMediaLinks\Schemas\SocialMediaLinkInfolist;
use App\Filament\Resources\SocialMediaLinks\Tables\SocialMediaLinksTable;
use App\Models\SocialMediaLink;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SocialMediaLinkResource extends Resource
{
    protected static ?string $model = SocialMediaLink::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Landing Page';

    protected static ?string $navigationLabel = 'Media Sosial';

    protected static ?string $modelLabel = 'Tautan Media Sosial';

    protected static ?string $pluralModelLabel = 'Media Sosial';

    protected static ?int $navigationSort = 11;

    public static function form(Schema $schema): Schema
    {
        return SocialMediaLinkForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SocialMediaLinkInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SocialMediaLinksTable::configure($table);
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
            'index' => ListSocialMediaLinks::route('/'),
            'create' => CreateSocialMediaLink::route('/create'),
            'view' => ViewSocialMediaLink::route('/{record}'),
            'edit' => EditSocialMediaLink::route('/{record}/edit'),
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
