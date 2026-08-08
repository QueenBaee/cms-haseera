<?php

declare(strict_types=1);

namespace App\Filament\Resources\AboutBenefits;

use App\Filament\Resources\AboutBenefits\Pages\CreateAboutBenefit;
use App\Filament\Resources\AboutBenefits\Pages\EditAboutBenefit;
use App\Filament\Resources\AboutBenefits\Pages\ListAboutBenefits;
use App\Models\AboutBenefit;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class AboutBenefitResource extends Resource
{
    protected static ?string $model = AboutBenefit::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::CheckCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Website';

    protected static ?string $navigationLabel = 'Keunggulan (About)';

    protected static ?string $modelLabel = 'Keunggulan';

    protected static ?string $pluralModelLabel = 'Keunggulan';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                TextInput::make('title')->label('Judul')->required()->maxLength(255),
                TextInput::make('icon')->label('Icon')->helperText('Nama heroicon, contoh: check-circle'),
                Textarea::make('description')->label('Deskripsi')->rows(2)->columnSpanFull(),
                TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
                Toggle::make('is_active')->label('Aktif')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')->label('#')->sortable(),
                TextColumn::make('title')->label('Judul')->searchable(),
                TextColumn::make('icon')->label('Icon'),
                ToggleColumn::make('is_active')->label('Aktif'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAboutBenefits::route('/'),
            'create' => CreateAboutBenefit::route('/create'),
            'edit' => EditAboutBenefit::route('/{record}/edit'),
        ];
    }
}
