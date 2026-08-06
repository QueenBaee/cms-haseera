<?php

namespace App\Filament\Resources\PortfolioCategories\Pages;

use App\Filament\Resources\PortfolioCategories\PortfolioCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPortfolioCategory extends EditRecord
{
    protected static string $resource = PortfolioCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
