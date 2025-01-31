<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSubmission extends Model
{
    use HasUuids;
    protected $guarded =['id'];
    public function income(): HasMany
    {
        return $this->hasMany(Income::class, 'user_submission_id', 'id');
    }
    public function housingPatner() : BelongsTo
    {
        return $this->belongsTo(HousingPartner::class, 'housing_partner_id', 'id');
    }
}
