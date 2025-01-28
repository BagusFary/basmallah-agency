<?php

namespace App\Filament\Resources\HeroImagesResource\Pages;

use App\Filament\Resources\HeroImagesResource;
use App\Models\HeroImage;
use Auth;
use DB;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Symfony\Component\Uid\Ulid;

class CreateHeroImages extends CreateRecord
{
    protected static string $resource = HeroImagesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    // protected function handleRecordCreation(array $data): HeroImage
    // {

    //     if (isset($data['images']) && is_array($data['images'])) {
    //         foreach ($data['images'] as $image) {
    //             HeroImage::create([
    //                 'image_url' => $image['image_url'],
    //                 'user_id' => Auth::user()->id // Field di database
    //             ]);
    //         }
    //     }

    //     return new HeroImage();
    // }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {

    //     $userId = Auth::user()->id;

    //     // Simpan semua item ke database
    //     foreach ($data['images'] as $item) {

    //         if (empty($item) || !isset($item['image_url'])) {
    //             break; // Lewatkan elemen kosong atau tidak valid
    //         }
    //         HeroImage::create([
    //             'image_url' => $item['image_url'],
    //             'user_id' => $userId, // Tambahkan user_id ke setiap item
    //         ]);
    //     }



    //     return $data;
    // }
}
