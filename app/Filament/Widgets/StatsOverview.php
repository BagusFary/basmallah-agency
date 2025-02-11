<?php

namespace App\Filament\Widgets;

use App\Models\HousingPartner;
use App\Models\UserSubmission;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('User Submissions', UserSubmission::count())
                ->description('Jumlah User Submissions')
                ->icon('heroicon-o-document-duplicate')
                ->color('primary'),

            Stat::make('Housing Partners', HousingPartner::count())
                ->description('Jumlah Housing Partners')
                ->icon('heroicon-o-user-group')
                ->color('success'),
        ];
    }

    protected function getColumns(): int
    {
        return 2;
    }
}
