<?php

namespace App\Filament\Resources\PortfolioCategories\Pages;

use App\Filament\Resources\PortfolioCategories\PortfolioCategoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPortfolioCategory extends ViewRecord
{
    protected static string $resource = PortfolioCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
