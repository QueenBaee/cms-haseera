<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\AdminGoogleAllowlist;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Throwable;

class GoogleController extends Controller
{
    public function redirect(): SymfonyRedirectResponse
    {
        return Socialite::driver('google')
            ->setScopes(['openid', 'email', 'profile'])
            ->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            /** @var SocialiteUser $googleUser */
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $exception) {
            report($exception);

            return $this->deny('Login Google gagal. Silakan coba kembali.');
        }

        $email = AdminGoogleAllowlist::normalize($googleUser->getEmail());

        if (($email === null) || (! $this->hasVerifiedEmailWhenProvided($googleUser))) {
            return $this->deny('Login Google gagal. Silakan coba kembali.');
        }

        if (! AdminGoogleAllowlist::contains($email)) {
            return $this->deny('Akun ini tidak memiliki akses ke panel admin.');
        }

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->first();

        if ($user === null) {
            // Auto-create user if they're in the allowlist
            $user = User::create([
                'name' => $googleUser->getName() ?? $email,
                'email' => $email,
                'password' => Hash::make(Str::random(32)),
            ]);
        } else {
            // Check if existing user can access the admin panel
            if (! $user->canAccessPanel(filament()->getPanel('admin'))) {
                return $this->deny('Akun ini tidak memiliki akses ke panel admin.');
            }
        }

        Auth::login($user);
        request()->session()->regenerate();

        return redirect()->intended('/admin');
    }

    private function hasVerifiedEmailWhenProvided(SocialiteUser $googleUser): bool
    {
        $attributes = $googleUser->getRaw();

        foreach (['email_verified', 'verified_email'] as $key) {
            if (! Arr::has($attributes, $key)) {
                continue;
            }

            return filter_var(Arr::get($attributes, $key), FILTER_VALIDATE_BOOL) === true;
        }

        return true;
    }

    private function deny(string $message): RedirectResponse
    {
        Notification::make()
            ->title($message)
            ->danger()
            ->send();

        return redirect()->route('filament.admin.auth.login');
    }
}
