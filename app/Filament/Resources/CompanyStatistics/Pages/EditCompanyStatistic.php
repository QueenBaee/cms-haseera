<?php

namespace App\Filament\Resources\CompanyStatistics\Pages;

use App\Filament\Resources\CompanyStatistics\CompanyStatisticResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCompanyStatistic extends EditRecord
{
    protected static string $resource = CompanyStatisticResource::class;

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
