<?php

namespace App\Filament\Resources\Portfolios\Schemas;

use App\Enums\ContentAlignment;
use App\Enums\ImageFit;
use App\Enums\PortfolioLayoutVariant;
use App\Rules\GoogleDriveVideoUrl;
use App\Rules\InternalOrExternalUrl;
use App\Rules\YouTubeVideoUrl;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PortfolioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('portfolio_category_id')->label('Kategori')->relationship('category', 'name')->searchable()->preload(), TextInput::make('title')->label('Judul')->required(), TextInput::make('slug')->label('Slug')->unique(ignoreRecord: true), TextInput::make('eyebrow')->label('Eyebrow'), TextInput::make('client_name')->label('Klien'), DatePicker::make('project_date')->label('Tanggal Proyek'), TextInput::make('location')->label('Lokasi'), Textarea::make('short_description')->label('Deskripsi Singkat')->columnSpanFull(), RichEditor::make('description')->label('Deskripsi')->columnSpanFull(), self::image('thumbnail', 'Thumbnail'), self::image('cover_image', 'Gambar Sampul'), self::image('logo', 'Logo'), TextInput::make('youtube_video_url')->label('YouTube Video URL')->url()->nullable()->placeholder('https://www.youtube.com/watch?v=VIDEO_ID')->helperText('Optional. YouTube takes priority over Google Drive and local uploaded video.')->rules([new YouTubeVideoUrl]), TextInput::make('gdrive_video_url')->label('Google Drive Video URL')->url()->nullable()->placeholder('https://drive.google.com/file/d/VIDEO_ID/view')->helperText('Optional. Google Drive video will be used before the locally uploaded video.')->rules([new GoogleDriveVideoUrl]), FileUpload::make('video_file')->label('Portfolio Video')->disk('public')->directory('portfolio-videos')->visibility('public')->acceptedFileTypes(['video/mp4', 'video/webm'])->maxSize(20480)->preventFilePathTampering(), TextInput::make('project_url')->label('URL Proyek')->rules([new InternalOrExternalUrl]), TextInput::make('button_text')->label('Teks Tombol'), TagsInput::make('technologies')->label('Teknologi'), Select::make('layout_variant')->label('Varian Layout')->options(PortfolioLayoutVariant::options())->required()->default('image_left'), Select::make('image_fit')->label('Penyesuaian Gambar')->options(ImageFit::options())->required()->default('cover'), Select::make('content_alignment')->label('Posisi Konten')->options(ContentAlignment::options())->required()->default('left'), TextInput::make('sort_order')->label('Urutan')->numeric()->required()->default(0), Toggle::make('is_featured')->label('Unggulan'), Toggle::make('is_active')->label('Aktif')->default(true), TextInput::make('meta_title')->label('Meta Title'), Textarea::make('meta_description')->label('Meta Description')->columnSpanFull(), ]);
    }

    private static function image(string $name, string $label): FileUpload
    {
        return FileUpload::make($name)->label($label)->image()->disk('public')->directory('landing-page/portfolios')->visibility('public')->maxSize(5120)->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']);
    }
}
