<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSubmission extends Model
{
    // Merge Conflict This Model 
    use HasUuids;
    protected $table = 'user_submissions';
    protected $primary_key = 'id';
    protected $guarded = ['id'];
    public function income(): HasMany
    {
        return $this->hasMany(Income::class, 'user_submission_id', 'id');
    }
    public function housingPartner(): BelongsTo
    {
        return $this->belongsTo(HousingPartner::class, 'housing_partner_id', 'id');
    }
}
