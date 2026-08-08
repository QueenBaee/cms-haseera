<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContactMessageStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pesan Baru', ContactMessage::where('status', 'new')->count())
                ->description('Belum dibaca')
                ->color('danger'),

            Stat::make('Pesan Hari Ini', ContactMessage::whereDate('created_at', today())->count())
                ->description('Masuk hari ini')
                ->color('info'),

            Stat::make('Total Pesan', ContactMessage::count())
                ->description('Semua pesan')
                ->color('gray'),
        ];
    }
}
