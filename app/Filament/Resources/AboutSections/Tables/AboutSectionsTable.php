<?php

namespace App\Filament\Resources\AboutSections\Tables;

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
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class AboutSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('eyebrow')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('highlighted_text')
                    ->searchable(),
                ImageColumn::make('image'),
                ImageColumn::make('secondary_image'),
                TextColumn::make('video_url')
                    ->searchable(),
                TextColumn::make('button_text')
                    ->searchable(),
                TextColumn::make('button_url')
                    ->searchable(),
                IconColumn::make('button_new_tab')
                    ->boolean(),
                TextColumn::make('content_position')
                    ->searchable(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Status Aktif'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()->label('Hapus'),
                RestoreAction::make()->label('Pulihkan'),
                ForceDeleteAction::make()->label('Hapus Permanen'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada bagian Tentang Kami')
            ->emptyStateDescription('Klik tombol Tambah Bagian Tentang untuk membuat konten pertama.')
            ->paginationPageOptions([10, 25, 50]);
    }
}
