<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroImage extends Model
{
    use HasUlids;

    protected $table = 'hero_images';
    protected $guarded = ['id'];

    protected static function booted()
    {
        // parent::boot();
        $filamentStorage = Storage::disk('filament_disk');

        static::deleting(function ($heroImage) use ($filamentStorage) {
            if ($heroImage->image_url && $filamentStorage->exists($heroImage->image_url)) {
                $filamentStorage->delete($heroImage->image_url);
            }
        });

        
    }
}
