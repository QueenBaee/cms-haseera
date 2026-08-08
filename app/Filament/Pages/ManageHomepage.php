<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Actions\Action;
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

class ManageHomepage extends Page implements HasForms
{
    use InteractsWithForms;

    public string $view = 'filament.pages.manage-homepage';

    protected static string|\UnitEnum|null $navigationGroup = 'Website';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Home;

    protected static ?string $navigationLabel = 'Homepage';

    protected static ?string $title = 'Pengaturan Homepage';

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
                    Tabs::make('Sections')->tabs([

                        Tab::make('Hero')->schema([
                            TextInput::make('hero_badge')->label('Badge / Label Kecil')
                                ->helperText('Teks kecil di atas heading utama, contoh: "Creative Agency"'),
                            Textarea::make('hero_title')->label('Judul Hero')->rows(3)->required()
                                ->helperText('Judul besar. Gunakan enter untuk baris baru.'),
                            Textarea::make('hero_description')->label('Deskripsi')->rows(3),
                            TextInput::make('hero_primary_button_text')->label('Teks Tombol Utama'),
                            TextInput::make('hero_primary_button_url')->label('URL Tombol Utama'),
                            TextInput::make('hero_secondary_button_text')->label('Teks Tombol Sekunder'),
                            TextInput::make('hero_secondary_button_url')->label('URL Tombol Sekunder'),
                        ])->columns(2),

                        Tab::make('About')->schema([
                            TextInput::make('about_eyebrow')->label('Eyebrow / Label Kecil'),
                            TextInput::make('about_title')->label('Judul Seksi')->required(),
                            Textarea::make('about_description')->label('Deskripsi')->rows(4),
                        ])->columns(2),

                        Tab::make('Layanan')->schema([
                            TextInput::make('services_eyebrow')->label('Eyebrow'),
                            TextInput::make('services_title')->label('Judul Seksi'),
                            Textarea::make('services_description')->label('Deskripsi')->rows(3),
                        ])->columns(2),

                        Tab::make('Proyek')->schema([
                            TextInput::make('projects_eyebrow')->label('Eyebrow'),
                            TextInput::make('projects_title')->label('Judul Seksi'),
                            Textarea::make('projects_description')->label('Deskripsi')->rows(3),
                        ])->columns(2),

                        Tab::make('Testimoni')->schema([
                            TextInput::make('testimonials_eyebrow')->label('Eyebrow'),
                            TextInput::make('testimonials_title')->label('Judul Seksi'),
                            Textarea::make('testimonials_description')->label('Deskripsi')->rows(3),
                        ])->columns(2),

                        Tab::make('Footer CTA')->schema([
                            TextInput::make('cta_title')->label('Judul CTA'),
                            Textarea::make('cta_description')->label('Deskripsi CTA')->rows(3),
                            TextInput::make('cta_button_text')->label('Teks Tombol'),
                            TextInput::make('cta_button_url')->label('URL Tombol'),
                        ])->columns(2),

                    ])->columnSpanFull(),
                ])
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
            ->record($this->getRecord())
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        SiteSetting::updateOrCreate(['id' => 1], $data);

        Notification::make()->title('Homepage berhasil disimpan.')->success()->send();
    }
}
