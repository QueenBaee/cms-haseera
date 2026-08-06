<?php

namespace App\Filament\Resources\AboutSections\Schemas;

use App\Enums\AboutContentPosition;
use App\Rules\InternalOrExternalUrl;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class AboutSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('eyebrow')->label('Eyebrow'), TextInput::make('title')->label('Judul')->required(), TextInput::make('highlighted_text')->label('Teks Disorot'), Textarea::make('short_description')->label('Deskripsi Singkat')->columnSpanFull(), RichEditor::make('description')->label('Deskripsi')->columnSpanFull(), self::image('image', 'Gambar Utama'), self::image('secondary_image', 'Gambar Sekunder'), TextInput::make('video_url')->label('URL Video')->url(), TextInput::make('button_text')->label('Teks Tombol')->required(fn (Get $get): bool => filled($get('button_url'))), TextInput::make('button_url')->label('URL Tombol')->rules([new InternalOrExternalUrl])->required(fn (Get $get): bool => filled($get('button_text'))), Toggle::make('button_new_tab')->label('Buka di Tab Baru'), Select::make('content_position')->label('Posisi Konten')->options(AboutContentPosition::options())->required()->default('image_left'), TextInput::make('sort_order')->label('Urutan')->numeric()->required()->default(0), Toggle::make('is_active')->label('Aktif')->default(true), ]);
    }

    private static function image(string $name, string $label): FileUpload
    {
        return FileUpload::make($name)->label($label)->image()->disk('public')->directory('landing-page/about')->visibility('public')->maxSize(5120)->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']);
    }
}
