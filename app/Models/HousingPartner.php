<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class HousingPartner extends Model
{
    use HasUuids;

    protected $table = 'housing_partners';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];


    /**
     * Get the user that owns the HousingPartner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    protected static function booted()
    {
        $filamentStorage = Storage::disk('filament_disk');

        static::creating(function () {
            Cache::forget('index-housing-partners');
            Cache::forget('index-housing-list');
        });

        static::updating(function () {
            Cache::forget('index-housing-partners');
            Cache::forget('index-housing-list');
        });

        static::deleting(function ($housingPartner) use ($filamentStorage) {
            if ($housingPartner->image_url && $filamentStorage->exists($housingPartner->image_url)) {
                $filamentStorage->delete($housingPartner->image_url);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
