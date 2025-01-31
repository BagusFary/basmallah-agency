<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserSubmission extends Model
{
    use HasUuids;
    protected $table = 'user_submissions';
    protected $primary_key = 'id';
    protected $guarded = ['id'];
}
