<?php

namespace App\Filament\Resources\HeroImagesResource\Pages;

use App\Filament\Resources\HeroImagesResource;
use App\Models\HeroImage;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Storage;

class EditHeroImages extends EditRecord
{


    protected static string $resource = HeroImagesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


}
