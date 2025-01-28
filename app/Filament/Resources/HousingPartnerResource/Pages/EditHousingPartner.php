<?php

namespace App\Filament\Resources\HousingPartnerResource\Pages;

use App\Filament\Resources\HousingPartnerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHousingPartner extends EditRecord
{
    protected static string $resource = HousingPartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
