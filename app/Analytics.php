<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    public $table = 'analytics';

    public $fillable = ['user_id', 'username', 'session_time', 'completed_experiences', 'opened_app'];
}