<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    public string $view = 'filament.pages.manage-site-settings';

    protected static string|\UnitEnum|null $navigationGroup = 'Konfigurasi';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;

    protected static ?string $navigationLabel = 'Pengaturan Situs';

    protected static ?string $title = 'Pengaturan Situs';

    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::instance()->toArray());
    }

    public function getRecord(): SiteSetting
    {
        return SiteSetting::instance();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    Tabs::make('Settings')->tabs([

                        Tab::make('Branding')->schema([
                            TextInput::make('site_name')->label('Nama Situs')->required(),
                            TextInput::make('site_tagline')->label('Tagline'),
                            ColorPicker::make('button_color')
                                ->label('Warna Tombol Utama')
                                ->nullable()
                                ->rules(['regex:/^#[0-9A-Fa-f]{6}$/'])
                                ->helperText('Pilih warna untuk semua tombol utama (Warna default: Lime #b5ff41).'),
                            FileUpload::make('logo')->label('Logo')->image()->directory('site')->disk('public'),
                            FileUpload::make('logo_dark')->label('Logo Dark Mode')->image()->directory('site')->disk('public'),
                            FileUpload::make('favicon')->label('Favicon')->image()->directory('site')->disk('public'),
                            FileUpload::make('background_image')
                                ->label('Background Image')
                                ->image()
                                ->disk('public')
                                ->directory('settings/backgrounds')
                                ->visibility('public')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->maxSize(5120)
                                ->columnSpanFull(),
                        ])->columns(2),

                        Tab::make('Perusahaan')->schema([
                            Textarea::make('company_description')->label('Deskripsi Perusahaan')->rows(4)->columnSpanFull(),
                            TextInput::make('phone')->label('Telepon'),
                            TextInput::make('whatsapp')->label('WhatsApp')->helperText('Format: 085691420774'),
                            TextInput::make('email')->label('Email')->email(),
                            Textarea::make('address')->label('Alamat')->rows(3)->columnSpanFull(),
                            TextInput::make('google_maps_url')->label('URL Google Maps')->url()->columnSpanFull(),
                        ])->columns(2),

                        Tab::make('Media Sosial')->schema([
                            TextInput::make('instagram_url')->label('Instagram URL')->url()->placeholder('https://instagram.com/username'),
                            TextInput::make('tiktok_url')->label('TikTok URL')->url()->placeholder('https://tiktok.com/@username'),
                            TextInput::make('youtube_url')->label('YouTube URL')->url()->placeholder('https://youtube.com/@channel'),
                            TextInput::make('facebook_url')->label('Facebook URL')->url(),
                            TextInput::make('linkedin_url')->label('LinkedIn URL')->url(),
                        ])->columns(2),

                        Tab::make('SEO')->schema([
                            TextInput::make('seo_title')->label('SEO Title'),
                            Textarea::make('seo_description')->label('SEO Description')->rows(3),
                            TextInput::make('seo_keywords')->label('Keywords'),
                            FileUpload::make('og_image')->label('OG Image')->image()->directory('site')->disk('public')->columnSpanFull(),
                        ])->columns(2),

                        Tab::make('Footer')->schema([
                            Textarea::make('footer_text')->label('Teks Footer')->rows(3)->columnSpanFull(),
                        ])->columns(1),

                        Tab::make('Kontak')->schema([
                            TextInput::make('contact_badge')->label('Badge Halaman')->placeholder('Kontak Kami'),
                            TextInput::make('contact_form_title')->label('Judul Form')->placeholder('Kirim Pesan'),
                            TextInput::make('contact_title')->label('Judul Halaman')->columnSpanFull()
                                ->placeholder('Mari Wujudkan Ide Anda Bersama Kami'),
                            Textarea::make('contact_description')->label('Deskripsi')->rows(3)->columnSpanFull(),
                            TextInput::make('contact_quick_title')->label('Judul WhatsApp Cepat')->placeholder('Butuh respons cepat?'),
                            Textarea::make('contact_quick_description')->label('Deskripsi WhatsApp Cepat')->rows(2)->columnSpanFull()
                                ->placeholder('Chat langsung melalui WhatsApp — tim kami siap membantu.'),
                        ])->columns(2),

                    ])->columnSpanFull(),
                ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Simpan Perubahan')
                                ->icon(Heroicon::Check)
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $settings = SiteSetting::instance();
        $previousBackgroundImage = $settings->background_image;
        $data = $this->form->getState();
        $settings->update($data);

        if (
            filled($previousBackgroundImage)
            && $previousBackgroundImage !== $settings->background_image
            && str_starts_with($previousBackgroundImage, 'settings/backgrounds/')
        ) {
            Storage::disk('public')->delete($previousBackgroundImage);
        }

        Notification::make()->title('Pengaturan situs berhasil disimpan.')->success()->send();
    }
}
