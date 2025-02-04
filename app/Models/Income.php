<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{

    protected $guarded = ['id'];

    public function userSubmission(): BelongsTo
    {
        return $this->belongsTo(UserSubmission::class, 'user_submission_id', 'id');
    }

}
