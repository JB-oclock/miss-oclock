<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function players() {
        return $this->belongsToMany('App\Player')->withPivot('step', 'winner', 'question');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }
}
