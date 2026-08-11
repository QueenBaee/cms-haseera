<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            TextEntry::make('title')->label('Judul'),
            TextEntry::make('slug')->label('Slug'),
            TextEntry::make('short_description')->label('Deskripsi Singkat')->columnSpanFull(),

            RepeatableEntry::make('items')
                ->label('Daftar Item Layanan')
                ->schema([
                    TextEntry::make('label')->label('Item')->hiddenLabel(),
                ])
                ->columnSpanFull(),

            TextEntry::make('sort_order')->label('Urutan'),
            IconEntry::make('is_featured')->label('Unggulan')->boolean(),
            IconEntry::make('is_active')->label('Aktif')->boolean(),
            TextEntry::make('updated_at')->label('Terakhir Diubah')->dateTime(),

            Section::make('Informasi Lanjutan')
                ->collapsed()
                ->columnSpanFull()
                ->schema([
                    TextEntry::make('eyebrow')->label('Eyebrow'),
                    TextEntry::make('description')->label('Deskripsi Panjang')->html()->columnSpanFull(),
                    TextEntry::make('icon')->label('Ikon'),
                    TextEntry::make('button_text')->label('Teks Tombol'),
                    TextEntry::make('button_url')->label('URL Tombol'),
                    TextEntry::make('display_variant')->label('Varian'),
                    TextEntry::make('meta_title')->label('Meta Title'),
                    TextEntry::make('meta_description')->label('Meta Description')->columnSpanFull(),
                ]),
        ]);
    }
}
