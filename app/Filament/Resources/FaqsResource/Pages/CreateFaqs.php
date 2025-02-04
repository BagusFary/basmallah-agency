<?php

namespace App\Filament\Resources\FaqsResource\Pages;

use App\Filament\Resources\FaqsResource;
use Filament\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\CreateRecord;


class CreateFaqs extends CreateRecord
{
    protected static string $resource = FaqsResource::class;

    public function getHeading(): string
    {
        return __('Create FAQ');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


}
