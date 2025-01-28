<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Storage;

class HeroImage extends Model
{
    use HasUlids;

    protected $table = 'hero_images';
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($heroImage) {
            if($heroImage->image_url && Storage::disk('public')->exists($heroImage->image_url)){
                Storage::disk('public')->delete($heroImage->image_url);
            }
        });
    }

    
}
