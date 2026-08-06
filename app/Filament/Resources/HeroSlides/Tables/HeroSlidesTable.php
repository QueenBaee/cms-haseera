<?php

namespace App\Filament\Resources\HeroSlides\Tables;

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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HeroSlidesTable
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
                TextColumn::make('subtitle')
                    ->searchable(),
                ImageColumn::make('desktop_image'),
                ImageColumn::make('mobile_image'),
                ImageColumn::make('background_image'),
                TextColumn::make('primary_button_text')
                    ->searchable(),
                TextColumn::make('primary_button_url')
                    ->searchable(),
                IconColumn::make('primary_button_new_tab')
                    ->boolean(),
                TextColumn::make('secondary_button_text')
                    ->searchable(),
                TextColumn::make('secondary_button_url')
                    ->searchable(),
                IconColumn::make('secondary_button_new_tab')
                    ->boolean(),
                TextColumn::make('content_alignment')
                    ->searchable(),
                TextColumn::make('vertical_alignment')
                    ->searchable(),
                TextColumn::make('overlay_opacity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
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
                Filter::make('published')->label('Sudah Dipublikasikan')->query(fn (Builder $query) => $query->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))),
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
            ->emptyStateHeading('Belum ada Hero')
            ->emptyStateDescription('Klik tombol Tambah Hero untuk membuat konten hero pertama.')
            ->paginationPageOptions([10, 25, 50]);
    }
}
