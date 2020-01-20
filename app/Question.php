<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function games()
    {
        return $this->belongsToMany('App\Game');
    }
}
