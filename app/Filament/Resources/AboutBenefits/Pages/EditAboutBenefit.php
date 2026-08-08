<?php

declare(strict_types=1);

namespace App\Filament\Resources\AboutBenefits\Pages;

use App\Filament\Resources\AboutBenefits\AboutBenefitResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAboutBenefit extends EditRecord
{
    protected static string $resource = AboutBenefitResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()->label('Hapus')];
    }

    public function getTitle(): string
    {
        return 'Edit Keunggulan';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Keunggulan berhasil diperbarui.';
    }
}
