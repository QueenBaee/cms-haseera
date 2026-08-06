<?php

namespace App\Filament\Resources\Portfolios\Tables;

use App\Enums\PortfolioLayoutVariant;
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

class PortfoliosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('portfolio_category_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('eyebrow')
                    ->searchable(),
                TextColumn::make('client_name')
                    ->searchable(),
                TextColumn::make('project_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('location')
                    ->searchable(),
                TextColumn::make('thumbnail')
                    ->searchable(),
                ImageColumn::make('cover_image'),
                TextColumn::make('logo')
                    ->searchable(),
                TextColumn::make('project_url')
                    ->searchable(),
                TextColumn::make('button_text')
                    ->searchable(),
                TextColumn::make('layout_variant')
                    ->searchable(),
                ImageColumn::make('image_fit'),
                TextColumn::make('content_alignment')
                    ->searchable(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('meta_title')
                    ->searchable(),
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
                TernaryFilter::make('is_featured')->label('Unggulan'),
                SelectFilter::make('portfolio_category_id')->label('Kategori')->relationship('category', 'name'),
                SelectFilter::make('layout_variant')->label('Varian Layout')->options(PortfolioLayoutVariant::options()),
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
            ->emptyStateHeading('Belum ada portofolio')
            ->emptyStateDescription('Klik tombol Tambah Portofolio untuk membuat portofolio pertama.')
            ->paginationPageOptions([10, 25, 50]);
    }
}
