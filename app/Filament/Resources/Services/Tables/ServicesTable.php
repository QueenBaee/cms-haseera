<?php

namespace App\Filament\Resources\Services\Tables;

use App\Enums\ServiceDisplayVariant;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([ImageColumn::make('image')->label('Gambar')->disk('public'), TextColumn::make('title')->label('Judul')->searchable()->sortable(), TextColumn::make('slug')->label('Slug')->searchable(), TextColumn::make('display_variant')->label('Varian')->badge(), IconColumn::make('is_featured')->label('Unggulan')->boolean(), IconColumn::make('is_active')->label('Aktif')->boolean(), TextColumn::make('sort_order')->label('Urutan')->sortable(), TextColumn::make('updated_at')->label('Terakhir Diubah')->dateTime()->sortable()])->defaultSort('sort_order')->filters([TernaryFilter::make('is_active')->label('Aktif'), TernaryFilter::make('is_featured')->label('Unggulan'), SelectFilter::make('display_variant')->label('Varian')->options(ServiceDisplayVariant::options()), TrashedFilter::make()->label('Data Terhapus')])->recordActions([ViewAction::make()->label('Lihat'), EditAction::make()->label('Edit'), DeleteAction::make()->label('Hapus'), RestoreAction::make()->label('Pulihkan'), ForceDeleteAction::make()->label('Hapus Permanen')])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()->label('Hapus'), RestoreBulkAction::make()->label('Pulihkan'), ForceDeleteBulkAction::make()->label('Hapus Permanen')])])->emptyStateHeading('Belum ada layanan')->emptyStateDescription('Klik tombol Tambah Layanan untuk membuat layanan pertama.')->paginationPageOptions([10, 25, 50]);
    }
}
