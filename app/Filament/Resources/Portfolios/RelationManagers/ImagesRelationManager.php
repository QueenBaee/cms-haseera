<?php

namespace App\Filament\Resources\Portfolios\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Galeri Portofolio';

    public function form(Schema $schema): Schema
    {
        return $schema->components([FileUpload::make('image')->label('Gambar')->required()->image()->disk('public')->directory('landing-page/portfolios/gallery')->visibility('public')->maxSize(5120)->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']), TextInput::make('caption')->label('Keterangan'), TextInput::make('alt_text')->label('Teks Alternatif'), TextInput::make('sort_order')->label('Urutan')->numeric()->required()->default(0)]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([ImageEntry::make('image')->label('Gambar')->disk('public'), TextEntry::make('caption')->label('Keterangan'), TextEntry::make('alt_text')->label('Teks Alternatif'), TextEntry::make('sort_order')->label('Urutan')]);
    }

    public function table(Table $table): Table
    {
        return $table->recordTitleAttribute('caption')->columns([ImageColumn::make('image')->label('Gambar')->disk('public'), TextColumn::make('caption')->label('Keterangan')->searchable(), TextColumn::make('alt_text')->label('Teks Alternatif'), TextColumn::make('sort_order')->label('Urutan')->sortable()])->defaultSort('sort_order')->headerActions([CreateAction::make()->label('Tambah Gambar')])->recordActions([ViewAction::make()->label('Lihat'), EditAction::make()->label('Edit'), DeleteAction::make()->label('Hapus')])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()->label('Hapus')])]);
    }
}
