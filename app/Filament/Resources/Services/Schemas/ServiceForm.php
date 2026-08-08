<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Enums\ServiceDisplayVariant;
use App\Rules\InternalOrExternalUrl;
use App\Support\HeroiconOptions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Judul')->required(), TextInput::make('slug')->label('Slug')->unique(ignoreRecord: true), TextInput::make('eyebrow')->label('Eyebrow'), Textarea::make('short_description')->label('Deskripsi Singkat')->columnSpanFull(), RichEditor::make('description')->label('Deskripsi')->columnSpanFull(), Select::make('icon')->label('Ikon')->options(HeroiconOptions::all())->searchable()->preload()->native(false)->placeholder('Pilih ikon')->helperText('Pilih ikon yang mewakili layanan ini.'), self::image('image', 'Gambar'), self::image('background_image', 'Gambar Latar'), TextInput::make('button_text')->label('Teks Tombol')->required(fn (Get $get): bool => filled($get('button_url'))), TextInput::make('button_url')->label('URL Tombol')->rules([new InternalOrExternalUrl])->required(fn (Get $get): bool => filled($get('button_text'))), Toggle::make('open_new_tab')->label('Buka di Tab Baru'), Select::make('display_variant')->label('Varian Tampilan')->options(ServiceDisplayVariant::options())->required()->default('card'), TextInput::make('sort_order')->label('Urutan')->numeric()->required()->default(0), Toggle::make('is_featured')->label('Unggulan'), Toggle::make('is_active')->label('Aktif')->default(true), TextInput::make('meta_title')->label('Meta Title'), Textarea::make('meta_description')->label('Meta Description')->columnSpanFull(), ]);
    }

    private static function image(string $name, string $label): FileUpload
    {
        return FileUpload::make($name)->label($label)->image()->disk('public')->directory('landing-page/services')->visibility('public')->maxSize(5120)->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']);
    }
}
