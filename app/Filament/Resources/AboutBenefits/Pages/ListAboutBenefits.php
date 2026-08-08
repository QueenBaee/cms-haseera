<?php

declare(strict_types=1);

namespace App\Filament\Resources\AboutBenefits\Pages;

use App\Filament\Resources\AboutBenefits\AboutBenefitResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAboutBenefits extends ListRecords
{
    protected static string $resource = AboutBenefitResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Tambah Keunggulan')];
    }

    public function getTitle(): string
    {
        return 'Daftar Keunggulan';
    }
}
