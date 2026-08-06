<?php

namespace App\Filament\Resources\CompanyStatistics\Pages;

use App\Filament\Resources\CompanyStatistics\CompanyStatisticResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCompanyStatistic extends ViewRecord
{
    protected static string $resource = CompanyStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
