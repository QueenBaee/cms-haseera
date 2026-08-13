<?php

use App\Filament\Pages\Auth\Login as GoogleOAuthLogin;
use App\Models\User;
use App\Providers\Filament\AdminPanelProvider;
use Filament\Auth\Pages\Login;
use Filament\Facades\Filament;
use Filament\Panel;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Livewire\Livewire;

beforeEach(function (): void {
    config()->set('haseera.admin_google_emails', ' Admin@Example.com, second@example.com ');
});

test('guest opening admin is redirected to the default login page', function () {
    $this->get('/admin')
        ->assertRedirect('/admin/login');
});

test('admin login page presents the default email and password form', function () {
    $this->get('/admin/login')
        ->assertSuccessful()
        ->assertSee('type="email"', escape: false)
        ->assertSee('wire:model="data.password"', escape: false)
        ->assertSee("'password'", escape: false)
        ->assertDontSee('Masuk dengan Google')
        ->assertDontSee(route('auth.google.redirect'), escape: false);
});

test('allowlisted user can authenticate with email and password', function () {
    $user = User::factory()->create(['email' => 'admin@example.com']);
    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(Login::class)
        ->fillForm([
            'email' => $user->email,
            'password' => 'password',
        ])
        ->call('authenticate')
        ->assertHasNoFormErrors();

    $this->assertAuthenticatedAs($user);
});

test('panel selects the default login when Google OAuth is disabled', function () {
    config()->set('haseera.google_oauth_enabled', false);

    $panel = (new AdminPanelProvider(app()))->panel(Panel::make());

    expect($panel->getLoginRouteAction())->toBe(Login::class);
});

test('panel selects the custom login when Google OAuth is enabled', function () {
    config()->set('haseera.google_oauth_enabled', true);

    $panel = (new AdminPanelProvider(app()))->panel(Panel::make());

    expect($panel->getLoginRouteAction())->toBe(GoogleOAuthLogin::class);

    Livewire::test(GoogleOAuthLogin::class)
        ->assertSee('Masuk dengan Google')
        ->assertSee(route('auth.google.redirect'), escape: false);
});

test('Google account outside the allowlist is denied', function () {
    Socialite::fake('google', googleUser('outsider@example.com'));

    $this->get(route('auth.google.callback'))
        ->assertRedirect('/admin/login');

    $this->assertGuest();
});

test('allowlisted Google account without an existing user is created and logged in', function () {
    Socialite::fake('google', googleUser('ADMIN@example.com'));

    $this->get(route('auth.google.callback'))
        ->assertRedirect('/admin');

    $user = User::query()->where('email', 'admin@example.com')->firstOrFail();

    $this->assertAuthenticatedAs($user);
});

test('allowlisted existing user is logged in and redirected to admin', function () {
    $user = User::factory()->create(['email' => 'admin@example.com']);
    Socialite::fake('google', googleUser(' ADMIN@EXAMPLE.COM '));

    $this->get(route('auth.google.callback'))
        ->assertRedirect('/admin');

    $this->assertAuthenticatedAs($user);
});

test('unverified Google email is denied', function () {
    User::factory()->create(['email' => 'admin@example.com']);
    Socialite::fake('google', googleUser('admin@example.com', verified: false));

    $this->get(route('auth.google.callback'))
        ->assertRedirect('/admin/login');

    $this->assertGuest();
});

test('authenticated user outside the allowlist cannot access admin panel', function () {
    $user = User::factory()->create(['email' => 'outsider@example.com']);

    expect($user->canAccessPanel(Filament::getPanel('admin')))->toBeFalse();
});

function googleUser(string $email, bool $verified = true): SocialiteUser
{
    return SocialiteUser::fake([
        'email' => $email,
        'email_verified' => $verified,
    ]);
}
