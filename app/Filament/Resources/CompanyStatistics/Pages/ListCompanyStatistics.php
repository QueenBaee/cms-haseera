<?php

namespace App\Filament\Resources\CompanyStatistics\Pages;

use App\Filament\Resources\CompanyStatistics\CompanyStatisticResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanyStatistics extends ListRecords
{
    protected static string $resource = CompanyStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
