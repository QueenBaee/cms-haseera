<?php

namespace App\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Pages\SimplePage;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class Login extends SimplePage
{
    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }
    }

    public function getTitle(): string|Htmlable
    {
        return 'Masuk ke CMS Haseera';
    }

    public function getHeading(): string|Htmlable|null
    {
        return 'Masuk ke CMS Haseera';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Gunakan akun Google admin yang telah diizinkan.';
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Actions::make([
                Action::make('googleLogin')
                    ->label('Masuk dengan Google')
                    ->url(route('auth.google.redirect'))
                    ->button()
                    ->color('primary'),
            ])->fullWidth(),
        ]);
    }
}
