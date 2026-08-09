<?php

use App\Models\User;
use Filament\Facades\Filament;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

beforeEach(function (): void {
    config()->set('haseera.admin_google_emails', ' Admin@Example.com, second@example.com ');
});

test('guest opening admin is redirected to the Google-only login page', function () {
    $this->get('/admin')
        ->assertRedirect('/admin/login');
});

test('admin login page only presents Google authentication', function () {
    $this->get('/admin/login')
        ->assertSuccessful()
        ->assertSee('Masuk dengan Google')
        ->assertSee(route('auth.google.redirect'), escape: false)
        ->assertDontSee('type="password"', escape: false)
        ->assertDontSee('wire:model="data.email"', escape: false)
        ->assertDontSee('Lupa kata sandi')
        ->assertDontSee('Daftar');
});

test('Google account outside the allowlist is denied', function () {
    Socialite::fake('google', googleUser('outsider@example.com'));

    $this->get(route('auth.google.callback'))
        ->assertRedirect('/admin/login');

    $this->assertGuest();
});

test('allowlisted Google account without an existing user is denied', function () {
    Socialite::fake('google', googleUser('ADMIN@example.com'));

    $this->get(route('auth.google.callback'))
        ->assertRedirect('/admin/login');

    $this->assertGuest();
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
