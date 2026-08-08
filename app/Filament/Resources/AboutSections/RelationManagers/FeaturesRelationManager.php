<?php

namespace App\Filament\Resources\AboutSections\RelationManagers;

use App\Support\HeroiconOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FeaturesRelationManager extends RelationManager
{
    protected static string $relationship = 'features';

    protected static ?string $title = 'Fitur Tentang Kami';

    public function form(Schema $schema): Schema
    {
        return $schema->components([Select::make('icon')->label('Ikon')->options(HeroiconOptions::all())->searchable()->preload()->native(false)->placeholder('Pilih ikon (opsional)'), TextInput::make('title')->label('Judul')->required(), Textarea::make('description')->label('Deskripsi')->columnSpanFull(), TextInput::make('sort_order')->label('Urutan')->numeric()->required()->default(0), Toggle::make('is_active')->label('Aktif')->default(true)]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([TextEntry::make('icon')->label('Ikon'), TextEntry::make('title')->label('Judul'), TextEntry::make('description')->label('Deskripsi'), TextEntry::make('sort_order')->label('Urutan'), IconEntry::make('is_active')->label('Aktif')->boolean()]);
    }

    public function table(Table $table): Table
    {
        return $table->recordTitleAttribute('title')->columns([TextColumn::make('icon')->label('Ikon'), TextColumn::make('title')->label('Judul')->searchable()->sortable(), TextColumn::make('description')->label('Deskripsi')->limit(50), TextColumn::make('sort_order')->label('Urutan')->sortable(), IconColumn::make('is_active')->label('Aktif')->boolean()])->defaultSort('sort_order')->headerActions([CreateAction::make()->label('Tambah Fitur')])->recordActions([ViewAction::make()->label('Lihat'), EditAction::make()->label('Edit'), DeleteAction::make()->label('Hapus')])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()->label('Hapus')])]);
    }
}
