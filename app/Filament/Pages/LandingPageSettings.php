<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\LandingPageSetting;
use App\Services\LandingPageService;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class LandingPageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.landing-page-settings';

    protected static string|\UnitEnum|null $navigationGroup = 'Konfigurasi';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;

    protected static ?string $navigationLabel = 'Pengaturan Landing Page';

    protected static ?string $title = 'Pengaturan Landing Page';

    protected static ?int $navigationSort = 2;

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return Gate::allows('viewAny', LandingPageSetting::class);
    }

    public function mount(): void
    {
        Gate::authorize('create', LandingPageSetting::class);
        $setting = LandingPageSetting::query()->firstOrCreate(['id' => 1], ['site_name' => config('app.name', 'Haseera')]);
        $this->form->fill($setting->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([
                Tabs::make('Pengaturan')->tabs([
                    Tab::make('Informasi Umum')->schema([
                        Grid::make(2)->schema([
                            TextInput::make('site_name')->label('Nama Situs')->required()->maxLength(255),
                            TextInput::make('company_name')->label('Nama Perusahaan')->maxLength(255),
                            TextInput::make('site_tagline')->label('Tagline')->maxLength(255),
                            Textarea::make('company_description')->label('Deskripsi Perusahaan')->columnSpanFull(),
                        ]),
                    ]),
                    Tab::make('Branding')->schema([
                        Section::make('Logo dan Identitas')->schema([
                            self::imageUpload('logo', 'Logo', 'landing-page/branding'),
                            self::imageUpload('logo_dark', 'Logo Mode Gelap', 'landing-page/branding'),
                            self::imageUpload('favicon', 'Favicon', 'landing-page/branding'),
                            self::imageUpload('default_og_image', 'Gambar OG Default', 'landing-page/seo'),
                        ])->columns(2),
                    ]),
                    Tab::make('Kontak')->schema([
                        Grid::make(2)->schema([
                            TextInput::make('primary_email')->label('Email Utama')->email(),
                            TextInput::make('secondary_email')->label('Email Sekunder')->email(),
                            TextInput::make('phone')->label('Telepon'),
                            TextInput::make('whatsapp')->label('WhatsApp'),
                            Textarea::make('address')->label('Alamat')->columnSpanFull(),
                            TextInput::make('google_maps_url')->label('URL Google Maps')->url()->columnSpanFull(),
                        ]),
                    ]),
                    Tab::make('Judul Section')->schema([
                        self::sectionHeading('Statistik', 'statistics'),
                        self::sectionHeading('Layanan', 'services'),
                        self::sectionHeading('Portofolio', 'portfolio'),
                        self::sectionHeading('Testimoni', 'testimonials'),
                    ]),
                    Tab::make('Visibilitas Section')->schema([
                        Grid::make(3)->schema(collect(['header' => 'Header', 'hero' => 'Hero', 'statistics' => 'Statistik', 'about' => 'Tentang Kami', 'services' => 'Layanan', 'portfolio' => 'Portofolio', 'testimonials' => 'Testimoni', 'cta' => 'Call to Action', 'footer' => 'Footer'])->map(fn (string $label, string $key) => Toggle::make("show_{$key}")->label($label)->default(true))->all()),
                    ]),
                    Tab::make('SEO')->schema([
                        TextInput::make('default_meta_title')->label('Meta Title Default')->maxLength(255),
                        Textarea::make('default_meta_description')->label('Meta Description Default')->columnSpanFull(),
                    ]),
                    Tab::make('Footer')->schema([
                        Textarea::make('footer_description')->label('Deskripsi Footer')->columnSpanFull(),
                        TextInput::make('copyright_text')->label('Teks Hak Cipta')->maxLength(255),
                    ]),
                ])->columnSpanFull(),
            ])
                ->footer([
                    Actions::make([
                        Action::make('save')
                            ->label('Simpan Pengaturan')
                            ->submit('save')
                            ->keyBindings(['mod+s']),
                    ]),
                ]),
        ])->statePath('data');
    }

    public function save(): void
    {
        $setting = LandingPageSetting::query()->firstOrFail();
        Gate::authorize('update', $setting);
        DB::transaction(fn () => LandingPageSetting::query()->updateOrCreate(['id' => 1], $this->form->getState()));
        LandingPageService::clearAllCache();
        Notification::make()->title('Pengaturan landing page berhasil disimpan.')->success()->send();
    }

    private static function imageUpload(string $name, string $label, string $directory): FileUpload
    {
        return FileUpload::make($name)->label($label)->image()->disk('public')->directory($directory)->visibility('public')->maxSize(5120)->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    private static function sectionHeading(string $label, string $prefix): Section
    {
        return Section::make($label)->schema([
            TextInput::make("{$prefix}_eyebrow")->label('Eyebrow'),
            TextInput::make("{$prefix}_title")->label('Judul'),
            Textarea::make("{$prefix}_description")->label('Deskripsi')->columnSpanFull(),
        ])->columns(2);
    }
}
