<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UserSubmission extends Model
{
    // Merge Conflict This Model
    use HasUuids;
    protected $table = 'user_submissions';
    protected $primary_key = 'id';
    protected $guarded = ['id'];
    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class, 'user_submission_id', 'id');
    }

    public function housingPartner(): BelongsTo
    {
        return $this->belongsTo(HousingPartner::class, 'housing_partner_id', 'id');
    }


    /**
     * Get the user that owns the UserSubmission
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_submission(): BelongsTo
    {
        return $this->belongsTo(HousingPartner::class, 'housing_partner_id', 'id');
    }
}
