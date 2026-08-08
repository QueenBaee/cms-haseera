<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        /** @var ContactMessage $msg */
        $msg = $this->record;

        // Auto mark as read hanya jika status masih 'new'
        if ($msg->status === 'new') {
            $msg->update(['status' => 'read', 'read_at' => now()]);
            $this->refreshFormData(['status', 'read_at']);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('update_status')
                ->label('Ubah Status')
                ->icon(Heroicon::PencilSquare)
                ->form([
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'new' => 'Baru',
                            'read' => 'Sudah Dibaca',
                            'in_progress' => 'Diproses',
                            'done' => 'Selesai',
                            'spam' => 'Spam',
                        ])
                        ->required()
                        ->default(fn () => $this->record->status),
                ])
                ->action(function (array $data): void {
                    $this->record->update(['status' => $data['status']]);
                    $this->refreshFormData(['status']);
                    Notification::make()->title('Status berhasil diperbarui.')->success()->send();
                }),

            DeleteAction::make()
                ->successRedirectUrl(ContactMessageResource::getUrl()),
        ];
    }
}
