<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\CallToActionSetting;
use App\Rules\InternalOrExternalUrl;
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
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CallToActionSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.call-to-action-settings';

    protected static string|\UnitEnum|null $navigationGroup = 'Konfigurasi';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Megaphone;

    protected static ?string $navigationLabel = 'Call to Action';

    protected static ?string $title = 'Pengaturan Call to Action';

    protected static ?int $navigationSort = 3;

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return Gate::allows('viewAny', CallToActionSetting::class);
    }

    public function mount(): void
    {
        Gate::authorize('create', CallToActionSetting::class);
        $setting = CallToActionSetting::query()->firstOrCreate(['id' => 1], ['title' => 'Call to Action', 'is_active' => true]);
        $this->form->fill($setting->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([
                Section::make('Konten')->schema([
                    TextInput::make('eyebrow')->label('Eyebrow'), TextInput::make('title')->label('Judul')->required(),
                    TextInput::make('highlighted_text')->label('Teks Disorot'), Textarea::make('description')->label('Deskripsi')->columnSpanFull(),
                    FileUpload::make('background_image')->label('Gambar Latar')->image()->disk('public')->directory('landing-page/cta')->visibility('public')->maxSize(5120)->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
                    Toggle::make('is_active')->label('Aktif')->default(true),
                ])->columns(2),
                self::buttonSection('Tombol Utama', 'primary'),
                self::buttonSection('Tombol Sekunder', 'secondary'),
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
        $setting = CallToActionSetting::query()->firstOrFail();
        Gate::authorize('update', $setting);
        DB::transaction(fn () => CallToActionSetting::query()->updateOrCreate(['id' => 1], $this->form->getState()));
        LandingPageService::clearAllCache();
        Notification::make()->title('Pengaturan Call to Action berhasil disimpan.')->success()->send();
    }

    private static function buttonSection(string $title, string $prefix): Section
    {
        return Section::make($title)->schema([
            TextInput::make("{$prefix}_button_text")->label('Teks Tombol')->required(fn (Get $get): bool => filled($get("{$prefix}_button_url")))->live(onBlur: true),
            TextInput::make("{$prefix}_button_url")->label('URL Tombol')->rules([new InternalOrExternalUrl])->required(fn (Get $get): bool => filled($get("{$prefix}_button_text")))->live(onBlur: true),
            Toggle::make("{$prefix}_button_new_tab")->label('Buka di Tab Baru'),
        ])->columns(2);
    }
}
