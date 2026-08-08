<?php

declare(strict_types=1);

namespace App\Filament\Resources\AboutBenefits\Pages;

use App\Filament\Resources\AboutBenefits\AboutBenefitResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutBenefit extends CreateRecord
{
    protected static string $resource = AboutBenefitResource::class;

    public function getTitle(): string
    {
        return 'Tambah Keunggulan';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Keunggulan berhasil ditambahkan.';
    }
}
