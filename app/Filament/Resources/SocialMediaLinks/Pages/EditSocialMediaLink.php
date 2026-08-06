<?php

namespace App\Filament\Resources\SocialMediaLinks\Pages;

use App\Filament\Resources\SocialMediaLinks\SocialMediaLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSocialMediaLink extends EditRecord
{
    protected static string $resource = SocialMediaLinkResource::class;

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
