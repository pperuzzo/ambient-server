<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebugRequest extends Model
{
    public $table = 'debug_requests';

    public $fillable = ['id', 'request'];
}