<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Techniques extends Model
{
    public $table = 'techniques';

    public $fillable = ['user_id', 'username', 'session_time', 'tech_name', 'completion'];
}