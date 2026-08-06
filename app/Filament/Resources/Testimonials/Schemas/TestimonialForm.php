<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use App\Enums\TestimonialCardVariant;
use App\Rules\InternalOrExternalUrl;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nama')->required(), TextInput::make('position')->label('Jabatan'), TextInput::make('company')->label('Perusahaan'), FileUpload::make('photo')->label('Foto')->image()->disk('public')->directory('landing-page/testimonials')->visibility('public')->maxSize(5120)->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']), Textarea::make('content')->label('Testimoni')->required()->columnSpanFull(), TextInput::make('rating')->label('Rating')->numeric()->minValue(1)->maxValue(5), TextInput::make('source')->label('Sumber'), TextInput::make('source_url')->label('URL Sumber')->rules([new InternalOrExternalUrl]), Select::make('card_variant')->label('Varian Kartu')->options(TestimonialCardVariant::options())->required()->default('standard'), TextInput::make('sort_order')->label('Urutan')->numeric()->required()->default(0), Toggle::make('is_featured')->label('Unggulan'), Toggle::make('is_active')->label('Aktif')->default(true), ]);
    }
}
