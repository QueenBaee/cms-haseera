<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactMessages;

use App\Filament\Resources\ContactMessages\Pages\ListContactMessages;
use App\Filament\Resources\ContactMessages\Pages\ViewContactMessage;
use App\Models\ContactMessage;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ChatBubbleLeftRight;

    protected static string|\UnitEnum|null $navigationGroup = 'Komunikasi';

    protected static ?string $navigationLabel = 'Pesan Kontak';

    protected static ?string $modelLabel = 'Pesan';

    protected static ?string $pluralModelLabel = 'Pesan Kontak';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = ContactMessage::where('status', 'new')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'new' => 'Baru',
                        'read' => 'Sudah Dibaca',
                        'in_progress' => 'Diproses',
                        'done' => 'Selesai',
                        'spam' => 'Spam',
                    ])
                    ->required(),
            ]),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Pengirim')->schema([
                TextEntry::make('name')->label('Nama'),
                TextEntry::make('email')->label('Email'),
                TextEntry::make('phone')->label('Telepon')->placeholder('—'),
                TextEntry::make('subject')->label('Subjek')->placeholder('—'),
                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'Baru',
                        'read' => 'Sudah Dibaca',
                        'in_progress' => 'Diproses',
                        'done' => 'Selesai',
                        'spam' => 'Spam',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'read' => 'gray',
                        'in_progress' => 'info',
                        'done' => 'success',
                        'spam' => 'danger',
                        default => 'gray',
                    }),
                TextEntry::make('read_at')->label('Dibaca Pada')->dateTime()->placeholder('Belum dibaca'),
                TextEntry::make('created_at')->label('Diterima')->dateTime(),
            ])->columns(2),

            Section::make('Pesan')->schema([
                TextEntry::make('message')->label('Isi Pesan')->columnSpanFull(),
            ]),

            Section::make('Metadata')->schema([
                TextEntry::make('ip_address')->label('IP Address')->placeholder('—'),
                TextEntry::make('user_agent')->label('User Agent')->placeholder('—')->limit(80),
            ])->columns(2)->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'Baru',
                        'read' => 'Sudah Dibaca',
                        'in_progress' => 'Diproses',
                        'done' => 'Selesai',
                        'spam' => 'Spam',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'read' => 'gray',
                        'in_progress' => 'info',
                        'done' => 'success',
                        'spam' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->placeholder('—'),

                TextColumn::make('subject')
                    ->label('Subjek')
                    ->searchable()
                    ->limit(40)
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'new' => 'Baru',
                        'read' => 'Sudah Dibaca',
                        'in_progress' => 'Diproses',
                        'done' => 'Selesai',
                        'spam' => 'Spam',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make()->label('Hapus'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('mark_read')
                        ->label('Tandai Sudah Dibaca')
                        ->icon(Heroicon::Eye)
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                if ($record->status === 'new') {
                                    $record->update(['status' => 'read', 'read_at' => now()]);
                                }
                            });
                        }),
                    BulkAction::make('mark_spam')
                        ->label('Tandai Spam')
                        ->icon(Heroicon::NoSymbol)
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['status' => 'spam'])),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada pesan')
            ->emptyStateDescription('Pesan dari pengunjung akan muncul di sini.');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactMessages::route('/'),
            'view' => ViewContactMessage::route('/{record}'),
        ];
    }
}
