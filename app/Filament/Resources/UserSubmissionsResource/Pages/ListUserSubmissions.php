<?php

namespace App\Filament\Resources\UserSubmissionsResource\Pages;

use App\Filament\Resources\UserSubmissionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserSubmissions extends ListRecords
{
    protected static string $resource = UserSubmissionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
