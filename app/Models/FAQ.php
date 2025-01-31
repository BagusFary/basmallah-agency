<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasUlids;
    protected $table = 'faqs';
    protected $guarded = ['id'];
}
