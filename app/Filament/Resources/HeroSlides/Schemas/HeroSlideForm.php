<?php

namespace App\Filament\Resources\HeroSlides\Schemas;

use App\Enums\ContentAlignment;
use App\Enums\VerticalAlignment;
use App\Rules\InternalOrExternalUrl;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class HeroSlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('eyebrow')->label('Eyebrow'), TextInput::make('title')->label('Judul')->required(), TextInput::make('highlighted_text')->label('Teks Disorot'), TextInput::make('subtitle')->label('Subjudul'), Textarea::make('description')->label('Deskripsi')->columnSpanFull(), self::image('desktop_image', 'Gambar Desktop'), self::image('mobile_image', 'Gambar Mobile'), self::image('background_image', 'Gambar Latar'), self::button('primary', 'Utama', 'text'), self::button('primary', 'Utama', 'url'), Toggle::make('primary_button_new_tab')->label('Tombol Utama di Tab Baru'), self::button('secondary', 'Sekunder', 'text'), self::button('secondary', 'Sekunder', 'url'), Toggle::make('secondary_button_new_tab')->label('Tombol Sekunder di Tab Baru'), Select::make('content_alignment')->label('Posisi Konten')->options(ContentAlignment::options())->required()->default('left'), Select::make('vertical_alignment')->label('Posisi Vertikal')->options(VerticalAlignment::options())->required()->default('center'), TextInput::make('overlay_opacity')->label('Opasitas Overlay')->numeric()->minValue(0)->maxValue(100)->required()->default(40), TextInput::make('sort_order')->label('Urutan')->numeric()->required()->default(0), Toggle::make('is_active')->label('Aktif')->default(true), DateTimePicker::make('published_at')->label('Jadwal Publikasi'), ]);
    }

    private static function image(string $name, string $label): FileUpload
    {
        return FileUpload::make($name)->label($label)->image()->disk('public')->directory('landing-page/hero')->visibility('public')->maxSize(5120)->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    private static function button(string $prefix, string $label, string $part): TextInput
    {
        $other = $part === 'text' ? 'url' : 'text';
        $field = "{$prefix}_button_{$part}";

        return TextInput::make($field)->label(($part === 'text' ? 'Teks' : 'URL')." Tombol {$label}")->when($part === 'url', fn (TextInput $input) => $input->rules([new InternalOrExternalUrl]))->required(fn (Get $get): bool => filled($get("{$prefix}_button_{$other}")));
    }
}
