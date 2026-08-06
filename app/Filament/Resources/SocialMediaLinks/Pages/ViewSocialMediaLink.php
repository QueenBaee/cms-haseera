<?php

namespace App\Filament\Resources\SocialMediaLinks\Pages;

use App\Filament\Resources\SocialMediaLinks\SocialMediaLinkResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSocialMediaLink extends ViewRecord
{
    protected static string $resource = SocialMediaLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
