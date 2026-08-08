<?php

declare(strict_types=1);

namespace App\Filament\Resources\Brands;

use App\Filament\Resources\Brands\Pages\CreateBrand;
use App\Filament\Resources\Brands\Pages\EditBrand;
use App\Filament\Resources\Brands\Pages\ListBrands;
use App\Models\Brand;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::BuildingStorefront;

    protected static string|\UnitEnum|null $navigationGroup = 'Website';

    protected static ?string $navigationLabel = 'Brand / Mitra';

    protected static ?string $modelLabel = 'Brand';

    protected static ?string $pluralModelLabel = 'Brand / Mitra';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                TextInput::make('name')
                    ->label('Nama Brand')
                    ->required()
                    ->maxLength(255),

                TextInput::make('website_url')
                    ->label('Website')
                    ->url()
                    ->maxLength(255)
                    ->placeholder('https://example.com'),

                FileUpload::make('logo')
                    ->label('Logo Brand')
                    ->image()
                    ->disk('public')
                    ->directory('brands')
                    ->visibility('public')
                    ->maxSize(5120)
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'])
                    ->helperText('Gunakan PNG, WebP, JPG atau SVG dengan background transparan jika tersedia.')
                    ->columnSpanFull(),

                Select::make('logo_background')
                    ->label('Background Logo')
                    ->options([
                        'auto' => 'Otomatis',
                        'light' => 'Terang',
                        'dark' => 'Gelap',
                        'transparent' => 'Transparan',
                    ])
                    ->default('auto')
                    ->required()
                    ->helperText('Pilih background yang membuat logo tetap terlihat jelas pada website dark.'),

                TextInput::make('logo_scale')
                    ->label('Skala Logo (%)')
                    ->numeric()
                    ->default(100)
                    ->minValue(70)
                    ->maxValue(180)
                    ->suffix('%')
                    ->helperText('Gunakan untuk memperbesar logo yang mempunyai ruang kosong besar di file asli. Normal = 100%.'),

                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->minValue(0)
                    ->default(0),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->height(40)
                    ->width(100)
                    ->extraImgAttributes(['style' => 'object-fit: contain;']),

                TextColumn::make('name')
                    ->label('Nama Brand')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('website_url')
                    ->label('Website')
                    ->limit(40)
                    ->url(fn (Brand $record): ?string => $record->website_url)
                    ->openUrlInNewTab(),

                TextColumn::make('logo_background')
                    ->label('Background')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'auto' => 'Auto',
                        'light' => 'Terang',
                        'dark' => 'Gelap',
                        'transparent' => 'Transparan',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'light' => 'gray',
                        'dark' => 'warning',
                        'transparent' => 'info',
                        default => 'success',
                    }),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                TernaryFilter::make('is_active')->label('Status Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()->label('Hapus'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada brand')
            ->emptyStateDescription('Klik tombol Tambah Brand untuk menambahkan brand pertama.');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBrands::route('/'),
            'create' => CreateBrand::route('/create'),
            'edit' => EditBrand::route('/{record}/edit'),
        ];
    }
}
