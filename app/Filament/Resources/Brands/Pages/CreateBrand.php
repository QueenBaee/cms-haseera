<?php

declare(strict_types=1);

namespace App\Filament\Resources\Brands\Pages;

use App\Filament\Resources\Brands\BrandResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBrand extends CreateRecord
{
    protected static string $resource = BrandResource::class;

    public function getTitle(): string
    {
        return 'Tambah Brand';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Brand berhasil ditambahkan.';
    }
}
