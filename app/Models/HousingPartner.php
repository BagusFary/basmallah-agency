<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($housingPartner) {
            if($housingPartner->image_url && Storage::disk('public')->exists($housingPartner->image_url)){
                Storage::disk('public')->delete($housingPartner->image_url);
            }
        });
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
}
