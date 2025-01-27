<?php

namespace App\Filament\Resources\HousingPartnerResource\Pages;

use App\Filament\Resources\HousingPartnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHousingPartners extends ListRecords
{
    protected static string $resource = HousingPartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
