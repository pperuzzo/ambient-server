<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    public $table = 'scenes';

    public $fillable = ['id', 'GameId', 'UserId', 'State'];
}
