<?php

namespace App\Filament\Resources\UserSubmissionsResource\Widgets;

use Carbon\Carbon;
use App\Models\UserSubmission;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CardUserSubmission extends BaseWidget
{
    protected function getColumns(): int {
        return 2;
    }
    protected function getStats(): array
    {
        // dd('test');
        return [
            Stat::make('Pengguna yang menginputkan hari ini', UserSubmission::whereDate('created_at', Carbon::today())->count())
            ->description('Jumlah yang mengisi data hari ini'),

            Stat::make('Total yang menginputkan data', UserSubmission::count())
            ->description('Total jumlah yang mengisi data')

        ];
    }
}
