<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function player()
    {
        return $this->belongsTo('App\Player');
    }

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
