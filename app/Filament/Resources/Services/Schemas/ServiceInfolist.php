<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([ImageEntry::make('image')->label('Gambar')->disk('public'), TextEntry::make('title')->label('Judul'), TextEntry::make('slug')->label('Slug'), TextEntry::make('eyebrow')->label('Eyebrow'), TextEntry::make('short_description')->label('Deskripsi Singkat'), TextEntry::make('description')->label('Deskripsi')->html()->columnSpanFull(), TextEntry::make('icon')->label('Ikon'), TextEntry::make('button_text')->label('Teks Tombol'), TextEntry::make('button_url')->label('URL Tombol'), TextEntry::make('display_variant')->label('Varian'), TextEntry::make('sort_order')->label('Urutan'), IconEntry::make('is_featured')->label('Unggulan')->boolean(), IconEntry::make('is_active')->label('Aktif')->boolean(), TextEntry::make('updated_at')->label('Terakhir Diubah')->dateTime()]);
    }
}
