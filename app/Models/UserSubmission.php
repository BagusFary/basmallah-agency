<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSubmission extends Model
{
    use HasUuids;
    protected $table = 'user_submissions';
    protected $primary_key = 'id';
    protected $guarded = ['id'];

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
