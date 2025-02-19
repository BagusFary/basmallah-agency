<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HousingPartnerImages extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        $filamentStorage = Storage::disk('filament_disk');

        static::deleting(function ($housingPartnerImages) use ($filamentStorage) {
            if ($housingPartnerImages->image_url && $filamentStorage->exists($housingPartnerImages->image_url)) {
                $filamentStorage->delete($housingPartnerImages->image_url);
            }
        });
    }
}
