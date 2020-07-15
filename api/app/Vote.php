<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public function player()
    {
        return $this->belongsTo('App\Player');
    }

    public function game()
    {
        return $this->belongsTo('App\Game');
    }


    public function vote()
    {
        return $this->belongsTo('App\Player', 'voted_player_id');
    }
}
